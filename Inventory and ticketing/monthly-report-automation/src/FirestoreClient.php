<?php

declare(strict_types=1);

namespace Syseze\MonthlyReport;

use Firebase\JWT\JWT;
use RuntimeException;

/**
 * Minimal Firestore REST client authenticated via a service account —
 * there's no official Firebase Admin SDK for PHP, so this signs its own
 * OAuth2 JWT-bearer assertion and talks to the Firestore REST API directly.
 */
class FirestoreClient
{
    private string $projectId;
    private string $clientEmail;
    private string $privateKey;
    private ?string $accessToken = null;
    private int $tokenExpiresAt = 0;

    public function __construct(string $serviceAccountPath)
    {
        if (!is_file($serviceAccountPath)) {
            throw new RuntimeException("Service account key not found at: {$serviceAccountPath}");
        }
        $json = json_decode((string) file_get_contents($serviceAccountPath), true);
        if (!is_array($json) || empty($json['project_id']) || empty($json['client_email']) || empty($json['private_key'])) {
            throw new RuntimeException('Service account key is missing required fields (project_id/client_email/private_key).');
        }
        $this->projectId = $json['project_id'];
        $this->clientEmail = $json['client_email'];
        $this->privateKey = $json['private_key'];
    }

    private function accessToken(): string
    {
        if ($this->accessToken !== null && time() < $this->tokenExpiresAt - 60) {
            return $this->accessToken;
        }

        $now = time();
        $jwt = JWT::encode([
            'iss' => $this->clientEmail,
            'scope' => 'https://www.googleapis.com/auth/datastore',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ], $this->privateKey, 'RS256');

        $response = $this->httpPost('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ], asForm: true);

        if (!isset($response['access_token'])) {
            throw new RuntimeException('Failed to obtain Firestore access token: ' . json_encode($response));
        }

        $this->accessToken = $response['access_token'];
        $this->tokenExpiresAt = $now + (int) ($response['expires_in'] ?? 3600);
        return $this->accessToken;
    }

    /** Fetches every document in a top-level collection, decoded to plain arrays. */
    public function listCollection(string $collectionId): array
    {
        $documents = [];
        $pageToken = null;

        do {
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/{$collectionId}"
                . '?pageSize=300' . ($pageToken ? '&pageToken=' . urlencode($pageToken) : '');
            $response = $this->httpGet($url);

            foreach ($response['documents'] ?? [] as $doc) {
                $id = basename($doc['name']);
                $documents[] = array_merge(['id' => $id], self::decodeFields($doc['fields'] ?? []));
            }

            $pageToken = $response['nextPageToken'] ?? null;
        } while ($pageToken !== null);

        return $documents;
    }

    private function httpGet(string $url): array
    {
        return $this->request('GET', $url, null, false);
    }

    private function httpPost(string $url, array $body, bool $asForm = false): array
    {
        return $this->request('POST', $url, $body, $asForm, includeAuth: false);
    }

    private function request(string $method, string $url, ?array $body, bool $asForm, bool $includeAuth = true): array
    {
        $ch = curl_init($url);
        $headers = [];

        if ($includeAuth) {
            $headers[] = 'Authorization: Bearer ' . $this->accessToken();
        }

        if ($method === 'POST' && $body !== null) {
            if ($asForm) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                $headers[] = 'Content-Type: application/json';
            }
            curl_setopt($ch, CURLOPT_POST, true);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException("Firestore request failed ({$method} {$url}): {$error}");
        }

        $decoded = json_decode((string) $raw, true) ?? [];
        if ($status >= 400) {
            throw new RuntimeException("Firestore request returned {$status} ({$method} {$url}): {$raw}");
        }

        return $decoded;
    }

    /** Converts Firestore's typed field-value wrappers into plain PHP values. */
    public static function decodeFields(array $fields): array
    {
        $out = [];
        foreach ($fields as $key => $wrapped) {
            $out[$key] = self::decodeValue($wrapped);
        }
        return $out;
    }

    private static function decodeValue(array $wrapped): mixed
    {
        if (array_key_exists('stringValue', $wrapped)) return $wrapped['stringValue'];
        if (array_key_exists('integerValue', $wrapped)) return (int) $wrapped['integerValue'];
        if (array_key_exists('doubleValue', $wrapped)) return (float) $wrapped['doubleValue'];
        if (array_key_exists('booleanValue', $wrapped)) return (bool) $wrapped['booleanValue'];
        if (array_key_exists('nullValue', $wrapped)) return null;
        if (array_key_exists('timestampValue', $wrapped)) return $wrapped['timestampValue'];
        if (array_key_exists('arrayValue', $wrapped)) {
            return array_map([self::class, 'decodeValue'], $wrapped['arrayValue']['values'] ?? []);
        }
        if (array_key_exists('mapValue', $wrapped)) {
            return self::decodeFields($wrapped['mapValue']['fields'] ?? []);
        }
        if (array_key_exists('referenceValue', $wrapped)) return $wrapped['referenceValue'];
        return null;
    }
}

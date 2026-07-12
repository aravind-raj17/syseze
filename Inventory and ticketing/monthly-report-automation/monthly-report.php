<?php

declare(strict_types=1);

/**
 * Monthly Asset & Support Report — run via Hostinger cron on the 1st of
 * every month. Pulls clients/assets/employees/tickets from Firestore (REST
 * API + service account, no Admin SDK needed), builds one branded .xlsx per
 * client, and emails it to that client's contactEmail via SMTP.
 *
 * Usage (CLI only — never expose this path under a web-accessible directory,
 * the service account key it loads can read/write the entire database):
 *   php /path/to/monthly-report.php
 */

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Syseze\MonthlyReport\FirestoreClient;
use Syseze\MonthlyReport\Logger;
use Syseze\MonthlyReport\Mailer;
use Syseze\MonthlyReport\ReportBuilder;

$root = __DIR__;
$logger = new Logger($root . '/logs');

try {
    if (is_file($root . '/.env')) {
        Dotenv\Dotenv::createImmutable($root)->load();
    }

    $required = ['SERVICE_ACCOUNT_PATH', 'SMTP_HOST', 'SMTP_PORT', 'SMTP_USER', 'SMTP_PASS', 'SMTP_FROM_EMAIL', 'SMTP_FROM_NAME'];
    foreach ($required as $key) {
        if (empty($_ENV[$key])) {
            throw new RuntimeException("Missing required .env value: {$key}");
        }
    }

    $serviceAccountPath = str_starts_with($_ENV['SERVICE_ACCOUNT_PATH'], '/')
        ? $_ENV['SERVICE_ACCOUNT_PATH']
        : $root . '/' . $_ENV['SERVICE_ACCOUNT_PATH'];

    $firestore = new FirestoreClient($serviceAccountPath);
    $mailer = new Mailer(
        host: $_ENV['SMTP_HOST'],
        port: (int) $_ENV['SMTP_PORT'],
        username: $_ENV['SMTP_USER'],
        password: $_ENV['SMTP_PASS'],
        fromEmail: $_ENV['SMTP_FROM_EMAIL'],
        fromName: $_ENV['SMTP_FROM_NAME'],
        encryption: $_ENV['SMTP_ENCRYPTION'] ?? 'ssl',
    );
    $reportBuilder = new ReportBuilder();

    $logger->info('Run started.');

    $clients = $firestore->listCollection('clients');
    $assets = $firestore->listCollection('assets');
    $employees = $firestore->listCollection('employees');
    $tickets = $firestore->listCollection('tickets');

    $logger->info(sprintf('Fetched %d clients, %d assets, %d employees, %d tickets.', count($clients), count($assets), count($employees), count($tickets)));

    $groupByClient = static function (array $items): array {
        $grouped = [];
        foreach ($items as $item) {
            $grouped[$item['clientId'] ?? ''][] = $item;
        }
        return $grouped;
    };
    $assetsByClient = $groupByClient($assets);
    $employeesByClient = $groupByClient($employees);
    $ticketsByClient = $groupByClient($tickets);

    $monthLabel = date('F Y');
    $tmpDir = sys_get_temp_dir();
    $sent = 0;
    $skipped = 0;
    $failed = 0;

    foreach ($clients as $client) {
        $clientId = $client['id'];
        $clientName = $client['name'] ?? 'Unknown client';
        $contactEmail = trim((string) ($client['contactEmail'] ?? ''));

        if ($contactEmail === '') {
            $logger->info("Skipped {$clientName}: no contactEmail on file.");
            $skipped++;
            continue;
        }

        try {
            $spreadsheet = $reportBuilder->build(
                $client,
                $assetsByClient[$clientId] ?? [],
                $employeesByClient[$clientId] ?? [],
                $ticketsByClient[$clientId] ?? [],
                $monthLabel,
            );

            $safeName = preg_replace('/[^A-Za-z0-9_-]+/', '-', $clientName);
            $fileName = "{$safeName}-Monthly-Report-" . date('Y-m') . '.xlsx';
            $filePath = $tmpDir . '/' . uniqid('report-', true) . '.xlsx';
            (new Xlsx($spreadsheet))->save($filePath);

            $subject = "Monthly Asset & Support Report — {$clientName} — {$monthLabel}";
            $bodyHtml = sprintf(
                '<p>Hi %s,</p><p>Attached is your monthly asset and support report for %s.</p><p>— Syseze IT Operations</p>',
                htmlspecialchars($client['contactPerson'] ?? 'there'),
                htmlspecialchars($monthLabel),
            );

            $mailer->sendReport($contactEmail, $clientName, $subject, $bodyHtml, $filePath, $fileName);
            unlink($filePath);

            $logger->info("Sent report to {$clientName} <{$contactEmail}>.");
            $sent++;
        } catch (Throwable $e) {
            $logger->error("Failed for {$clientName}: {$e->getMessage()}");
            $failed++;
        }
    }

    $logger->info(sprintf('Run complete. Sent: %d, skipped: %d, failed: %d.', $sent, $skipped, $failed));
} catch (Throwable $e) {
    $logger->error('Run aborted: ' . $e->getMessage());
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

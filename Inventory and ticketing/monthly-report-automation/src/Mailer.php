<?php

declare(strict_types=1);

namespace Syseze\MonthlyReport;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Mailer
{
    public function __construct(
        private string $host,
        private int $port,
        private string $username,
        private string $password,
        private string $fromEmail,
        private string $fromName,
        private string $encryption,
    ) {
    }

    public function sendReport(string $toEmail, string $toName, string $subject, string $bodyHtml, string $attachmentPath, string $attachmentName): void
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->Port = $this->port;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = $this->encryption;

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($toEmail, $toName);
            $mail->addAttachment($attachmentPath, $attachmentName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $bodyHtml;
            $mail->AltBody = strip_tags($bodyHtml);

            $mail->send();
        } catch (PHPMailerException $e) {
            throw new \RuntimeException("Failed to email {$toEmail}: {$mail->ErrorInfo}", previous: $e);
        }
    }
}

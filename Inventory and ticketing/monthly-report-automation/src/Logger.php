<?php

declare(strict_types=1);

namespace Syseze\MonthlyReport;

class Logger
{
    private string $path;

    public function __construct(string $logDir)
    {
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $this->path = rtrim($logDir, '/') . '/monthly-report-' . date('Y-m') . '.log';
    }

    public function info(string $message): void
    {
        $this->write('INFO', $message);
    }

    public function error(string $message): void
    {
        $this->write('ERROR', $message);
    }

    private function write(string $level, string $message): void
    {
        $line = sprintf('[%s] %s: %s%s', date('Y-m-d H:i:s'), $level, $message, PHP_EOL);
        file_put_contents($this->path, $line, FILE_APPEND | LOCK_EX);
    }
}

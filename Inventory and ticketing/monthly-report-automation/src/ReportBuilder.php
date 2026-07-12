<?php

declare(strict_types=1);

namespace Syseze\MonthlyReport;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Builds one branded .xlsx workbook per client: Summary, Assets, Employees,
 * Tickets — colored to match the status badges used in the web portal.
 */
class ReportBuilder
{
    private const BRAND_NAVY = '2B2560';

    private const ASSET_STATUS_COLORS = [
        'Active' => ['C6EFCE', '006100'],
        'Available' => ['D9F2EC', '0F766E'],
        'In Repair' => ['FFEB9C', '9C6500'],
        'Retired' => ['E5E7EB', '4B5563'],
        'Spare' => ['DBEAFE', '1E40AF'],
    ];

    private const EMPLOYEE_STATUS_COLORS = [
        'Active' => ['C6EFCE', '006100'],
        'Disable' => ['E5E7EB', '4B5563'],
        'Delete' => ['FFC7CE', '9C0006'],
        'Retain' => ['DBEAFE', '1E40AF'],
    ];

    private const TICKET_STATUS_COLORS = [
        'New' => ['DBEAFE', '1E40AF'],
        'Processing' => ['FFEB9C', '9C6500'],
        'Pending' => ['FFE0CC', '9C4500'],
        'Solved' => ['C6EFCE', '006100'],
        'Closed' => ['E5E7EB', '4B5563'],
    ];

    public function build(array $client, array $assets, array $employees, array $tickets, string $monthLabel): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        $this->addSummarySheet($spreadsheet, $client, $assets, $employees, $tickets, $monthLabel);
        $this->addAssetsSheet($spreadsheet, $assets);
        $this->addEmployeesSheet($spreadsheet, $employees);
        $this->addTicketsSheet($spreadsheet, $tickets);

        $spreadsheet->setActiveSheetIndex(0);
        return $spreadsheet;
    }

    private function addSummarySheet(Spreadsheet $spreadsheet, array $client, array $assets, array $employees, array $tickets, string $monthLabel): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Summary');

        $sheet->setCellValue('A1', self::sanitizeCell($client['name'] ?? 'Client'));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->setCellValue('A2', "Monthly Asset & Support Report — {$monthLabel}");
        $sheet->getStyle('A2')->getFont()->setItalic(true)->getColor()->setRGB('666666');

        $row = 4;
        $row = $this->writeCountTable($sheet, $row, 'Assets by Status', self::countBy($assets, 'status'), self::ASSET_STATUS_COLORS);
        $row++;
        $row = $this->writeCountTable($sheet, $row, 'Employees by Status', self::countBy($employees, 'status'), self::EMPLOYEE_STATUS_COLORS);
        $row++;

        $open = count(array_filter($tickets, fn ($t) => !in_array($t['status'] ?? '', ['Solved', 'Closed'], true)));
        $closed = count($tickets) - $open;
        $this->writeCountTable($sheet, $row, 'Tickets', ['Open' => $open, 'Closed' => $closed], [
            'Open' => ['FFE0CC', '9C4500'],
            'Closed' => ['C6EFCE', '006100'],
        ]);

        foreach (['A', 'B'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(22);
        }
    }

    private function writeCountTable(Worksheet $sheet, int $startRow, string $title, array $counts, array $colorMap): int
    {
        $sheet->setCellValue("A{$startRow}", $title);
        $sheet->getStyle("A{$startRow}")->getFont()->setBold(true)->setSize(12);
        $startRow++;

        $headerRow = $startRow;
        $sheet->setCellValue("A{$headerRow}", 'Status');
        $sheet->setCellValue("B{$headerRow}", 'Count');
        $this->styleHeaderRow($sheet, "A{$headerRow}:B{$headerRow}");
        $startRow++;

        foreach ($counts as $label => $count) {
            $sheet->setCellValue("A{$startRow}", $label);
            $sheet->setCellValue("B{$startRow}", $count);
            [$fill, $font] = $colorMap[$label] ?? ['F3F4F6', '374151'];
            $sheet->getStyle("A{$startRow}:B{$startRow}")->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fill);
            $sheet->getStyle("A{$startRow}:B{$startRow}")->getFont()->getColor()->setRGB($font);
            $startRow++;
        }

        return $startRow;
    }

    private function addAssetsSheet(Spreadsheet $spreadsheet, array $assets): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Assets');
        $columns = ['Asset Tag' => 'assetTag', 'Category' => 'category', 'Brand' => 'brand', 'Model' => 'model', 'Serial Number' => 'serialNumber', 'Status' => 'status', 'Location' => 'location', 'Assigned To' => 'assignedTo'];
        $this->writeTable($sheet, $columns, $assets, 'status', self::ASSET_STATUS_COLORS);
    }

    private function addEmployeesSheet(Spreadsheet $spreadsheet, array $employees): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Employees');
        $columns = ['Name' => 'name', 'Email' => 'email', 'License Assigned' => 'licenseAssigned', 'Status' => 'status'];
        $this->writeTable($sheet, $columns, $employees, 'status', self::EMPLOYEE_STATUS_COLORS);
    }

    private function addTicketsSheet(Spreadsheet $spreadsheet, array $tickets): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Tickets');
        $rows = array_map(function ($t) {
            $t['createdDate'] = self::formatTimestamp($t['createdAt'] ?? null);
            $t['resolvedDate'] = self::formatTimestamp($t['solvedAt'] ?? $t['closedAt'] ?? null);
            return $t;
        }, $tickets);
        $columns = ['Subject' => 'title', 'Status' => 'status', 'Created Date' => 'createdDate', 'Resolved Date' => 'resolvedDate'];
        $this->writeTable($sheet, $columns, $rows, 'status', self::TICKET_STATUS_COLORS);
    }

    private function writeTable(Worksheet $sheet, array $columns, array $rows, ?string $colorField, array $colorMap): void
    {
        $labels = array_keys($columns);
        $keys = array_values($columns);

        foreach ($labels as $i => $label) {
            $col = $this->columnLetter($i);
            $sheet->setCellValue("{$col}1", $label);
        }
        $this->styleHeaderRow($sheet, $this->columnLetter(0) . '1:' . $this->columnLetter(count($labels) - 1) . '1');

        $rowNum = 2;
        foreach ($rows as $row) {
            foreach ($keys as $i => $key) {
                $col = $this->columnLetter($i);
                $sheet->setCellValue("{$col}{$rowNum}", self::sanitizeCell($row[$key] ?? ''));
            }
            if ($colorField !== null) {
                $status = $row[$colorField] ?? '';
                [$fill, $font] = $colorMap[$status] ?? ['F3F4F6', '374151'];
                $range = $this->columnLetter(0) . $rowNum . ':' . $this->columnLetter(count($labels) - 1) . $rowNum;
                $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fill);
                $sheet->getStyle($range)->getFont()->getColor()->setRGB($font);
            }
            $rowNum++;
        }

        foreach ($labels as $i => $label) {
            $sheet->getColumnDimension($this->columnLetter($i))->setAutoSize(true);
        }
    }

    private function styleHeaderRow(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::BRAND_NAVY);
        $sheet->getStyle($range)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
    }

    private function columnLetter(int $index): string
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
    }

    private static function countBy(array $items, string $field): array
    {
        $counts = [];
        foreach ($items as $item) {
            $value = $item[$field] ?? 'Unspecified';
            $counts[$value] = ($counts[$value] ?? 0) + 1;
        }
        return $counts;
    }

    // CSV/formula-injection guard: PhpSpreadsheet's default value binder
    // treats a string starting with =, +, -, or @ as a live formula. Every
    // value written here can originate from staff-entered free text (asset
    // notes, ticket subjects, client/employee names...) and this workbook
    // is emailed straight to the client with no human review step, so it
    // must never reach Excel as anything but literal text.
    private static function sanitizeCell(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }
        return preg_match('/^[=+\-@\t\r]/', $value) === 1 ? "'" . $value : $value;
    }

    private static function formatTimestamp(?string $timestampValue): string
    {
        if (!$timestampValue) {
            return '';
        }
        $time = strtotime($timestampValue);
        return $time ? date('Y-m-d', $time) : '';
    }
}

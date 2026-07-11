import * as XLSX from 'xlsx';
import autoTable from 'jspdf-autotable';
import { toCSV, downloadBlob } from './csv';
import { EMPLOYEE_STATUSES } from '../employeeConstants';
import { createBrandedDoc, addBrandedFooter, BRAND_TABLE_HEAD_STYLE } from './pdfBranding';

export const EMPLOYEE_COLUMNS = [
  { key: 'name', label: 'Name' },
  { key: 'email', label: 'Email ID' },
  { key: 'organizationName', label: 'Organization Name' },
  { key: 'licenseAssigned', label: 'License Assigned' },
  { key: 'status', label: 'Status' },
];

const TEMPLATE_HEADERS = ['name', 'email', 'licenseAssigned', 'status'];

export function downloadEmployeeTemplate() {
  const example = {
    name: 'Jane Doe',
    email: 'jane.doe@example.com',
    licenseAssigned: 'M365 E3',
    status: EMPLOYEE_STATUSES[0],
  };
  const csv = toCSV(TEMPLATE_HEADERS, [example]);
  downloadBlob(csv, 'employee-upload-template.csv', 'text/csv;charset=utf-8;');
}

function employeeRows(employees) {
  return employees.map((e) => ({
    name: e.name,
    email: e.email,
    organizationName: e.organizationName || '',
    licenseAssigned: e.licenseAssigned || '',
    status: e.status,
  }));
}

export function exportEmployeesCSV(employees, filenameBase) {
  const csv = toCSV(EMPLOYEE_COLUMNS.map((c) => c.key), employeeRows(employees));
  downloadBlob(csv, `${filenameBase}.csv`, 'text/csv;charset=utf-8;');
}

export function exportEmployeesXLSX(employees, filenameBase) {
  const rows = employeeRows(employees).map((r) => {
    const out = {};
    EMPLOYEE_COLUMNS.forEach((c) => { out[c.label] = r[c.key]; });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: EMPLOYEE_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Employees');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export async function exportEmployeesPDF(employees, filenameBase, title) {
  const { doc, contentStartY } = await createBrandedDoc({
    title: title || 'Employee Directory',
    subtitle: `${employees.length} employee${employees.length === 1 ? '' : 's'}`,
    orientation: 'landscape',
  });

  autoTable(doc, {
    startY: contentStartY,
    head: [EMPLOYEE_COLUMNS.map((c) => c.label)],
    body: employeeRows(employees).map((r) => EMPLOYEE_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });

  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

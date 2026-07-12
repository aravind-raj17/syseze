import * as XLSX from 'xlsx';
import autoTable from 'jspdf-autotable';
import { toCSV, downloadBlob, sanitizeForSpreadsheet } from './csv';
import { createBrandedDoc, addBrandedFooter, BRAND_TABLE_HEAD_STYLE } from './pdfBranding';

export const DAILY_TASK_COLUMNS = [
  { key: 'date', label: 'Date' },
  { key: 'createdByName', label: 'Staff' },
  { key: 'clientName', label: 'Client' },
  { key: 'issuesAttended', label: 'Issues Attended' },
  { key: 'loginTime', label: 'Login' },
  { key: 'logoutTime', label: 'Logout' },
];

function taskRows(tasks) {
  return tasks.map((t) => ({
    date: t.date || '',
    createdByName: t.createdByName || t.createdBy || '',
    clientName: t.clientName || '',
    issuesAttended: t.issuesAttended || '',
    loginTime: t.loginTime || '',
    logoutTime: t.logoutTime || '',
  }));
}

export function exportDailyTasksCSV(tasks, filenameBase) {
  const csv = toCSV(DAILY_TASK_COLUMNS.map((c) => c.key), taskRows(tasks));
  downloadBlob(csv, `${filenameBase}.csv`, 'text/csv;charset=utf-8;');
}

export function exportDailyTasksXLSX(tasks, filenameBase) {
  const rows = taskRows(tasks).map((r) => {
    const out = {};
    DAILY_TASK_COLUMNS.forEach((c) => { out[c.label] = sanitizeForSpreadsheet(r[c.key]); });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: DAILY_TASK_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Daily Tasks');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export async function exportDailyTasksPDF(tasks, filenameBase, title) {
  const { doc, contentStartY } = await createBrandedDoc({
    title: title || 'Daily Tasks',
    subtitle: `${tasks.length} entr${tasks.length === 1 ? 'y' : 'ies'}`,
  });

  autoTable(doc, {
    startY: contentStartY,
    head: [DAILY_TASK_COLUMNS.map((c) => c.label)],
    body: taskRows(tasks).map((r) => DAILY_TASK_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });

  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

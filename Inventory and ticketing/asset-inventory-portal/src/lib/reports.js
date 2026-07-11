import * as XLSX from 'xlsx';
import autoTable from 'jspdf-autotable';
import { toCSV, downloadBlob } from './csv';
import { createBrandedDoc, addBrandedFooter, BRAND_TABLE_HEAD_STYLE } from './pdfBranding';
import { countByCategory as assetCountByCategory, countByStatus as assetCountByStatus } from './assetStats';

function clientName(clients, id) {
  return clients.find((c) => c.id === id)?.name || 'Unknown client';
}

function formatDate(ts) {
  return ts?.toDate ? ts.toDate().toLocaleDateString() : '';
}

// --- All-clients Asset report ---------------------------------------------

const ASSET_REPORT_COLUMNS = [
  { key: 'client', label: 'Client' },
  { key: 'assetTag', label: 'Asset Tag' },
  { key: 'category', label: 'Category' },
  { key: 'brand', label: 'Brand' },
  { key: 'model', label: 'Model' },
  { key: 'serialNumber', label: 'Serial Number' },
  { key: 'status', label: 'Status' },
  { key: 'location', label: 'Location' },
  { key: 'assignedTo', label: 'Assigned To' },
  { key: 'purchaseDate', label: 'Purchase Date' },
  { key: 'warrantyExpiry', label: 'Warranty Expiry' },
];

function assetReportRows(assets, clients) {
  return assets.map((a) => ({
    client: clientName(clients, a.clientId),
    assetTag: a.assetTag,
    category: a.category,
    brand: a.brand || '',
    model: a.model || '',
    serialNumber: a.serialNumber || '',
    status: a.status,
    location: a.location || '',
    assignedTo: a.assignedTo || '',
    purchaseDate: a.purchaseDate || '',
    warrantyExpiry: a.warrantyExpiry || '',
  }));
}

export function exportAllAssetsCSV(assets, clients, filenameBase) {
  const csv = toCSV(ASSET_REPORT_COLUMNS.map((c) => c.key), assetReportRows(assets, clients));
  downloadBlob(csv, `${filenameBase}.csv`, 'text/csv;charset=utf-8;');
}

export function exportAllAssetsXLSX(assets, clients, filenameBase) {
  const rows = assetReportRows(assets, clients).map((r) => {
    const out = {};
    ASSET_REPORT_COLUMNS.forEach((c) => { out[c.label] = r[c.key]; });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: ASSET_REPORT_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Assets');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export async function exportAllAssetsPDF(assets, clients, filenameBase) {
  const { doc, contentStartY } = await createBrandedDoc({
    title: 'Asset Inventory Report',
    subtitle: `All clients · ${assets.length} asset${assets.length === 1 ? '' : 's'}`,
  });
  autoTable(doc, {
    startY: contentStartY,
    head: [ASSET_REPORT_COLUMNS.map((c) => c.label)],
    body: assetReportRows(assets, clients).map((r) => ASSET_REPORT_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 7 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });
  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

// --- All-clients Ticket report ---------------------------------------------

const TICKET_REPORT_COLUMNS = [
  { key: 'client', label: 'Client' },
  { key: 'title', label: 'Title' },
  { key: 'type', label: 'Type' },
  { key: 'category', label: 'Category' },
  { key: 'status', label: 'Status' },
  { key: 'priority', label: 'Priority' },
  { key: 'requester', label: 'Requester' },
  { key: 'assignedTo', label: 'Assigned To' },
  { key: 'opened', label: 'Opened' },
];

function ticketReportRows(tickets, clients) {
  return tickets.map((t) => ({
    client: clientName(clients, t.clientId),
    title: t.title,
    type: t.type,
    category: t.category,
    status: t.status,
    priority: t.priority,
    requester: t.requester || '',
    assignedTo: t.assignedTo || '',
    opened: formatDate(t.createdAt),
  }));
}

export function exportAllTicketsCSV(tickets, clients, filenameBase) {
  const csv = toCSV(TICKET_REPORT_COLUMNS.map((c) => c.key), ticketReportRows(tickets, clients));
  downloadBlob(csv, `${filenameBase}.csv`, 'text/csv;charset=utf-8;');
}

export function exportAllTicketsXLSX(tickets, clients, filenameBase) {
  const rows = ticketReportRows(tickets, clients).map((r) => {
    const out = {};
    TICKET_REPORT_COLUMNS.forEach((c) => { out[c.label] = r[c.key]; });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: TICKET_REPORT_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Tickets');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export async function exportAllTicketsPDF(tickets, clients, filenameBase) {
  const { doc, contentStartY } = await createBrandedDoc({
    title: 'Ticket Report',
    subtitle: `All clients · ${tickets.length} ticket${tickets.length === 1 ? '' : 's'}`,
  });
  autoTable(doc, {
    startY: contentStartY,
    head: [TICKET_REPORT_COLUMNS.map((c) => c.label)],
    body: ticketReportRows(tickets, clients).map((r) => TICKET_REPORT_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 7 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });
  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

// --- Combined summary report (PDF only — heterogeneous tables don't
// meaningfully combine into one CSV/XLSX sheet) --------------------------

function countBy(items, key) {
  const counts = new Map();
  for (const item of items) {
    const k = item[key] || 'Unspecified';
    counts.set(k, (counts.get(k) || 0) + 1);
  }
  return [...counts.entries()].map(([label, value]) => [label, String(value)]);
}

export async function exportCombinedPDF(assets, tickets, employees, clients, filenameBase) {
  const { doc, contentStartY, pageWidth } = await createBrandedDoc({
    title: 'Portfolio Summary Report',
    subtitle: `${clients.length} client${clients.length === 1 ? '' : 's'} · Generated ${new Date().toLocaleDateString()}`,
  });

  let y = contentStartY;
  doc.setTextColor(0, 0, 0);
  doc.setFontSize(11);

  const openTickets = tickets.filter((t) => t.status !== 'Solved' && t.status !== 'Closed').length;

  autoTable(doc, {
    startY: y,
    head: [['Metric', 'Count']],
    body: [
      ['Clients', String(clients.length)],
      ['Assets', String(assets.length)],
      ['Employees', String(employees.length)],
      ['Tickets (total)', String(tickets.length)],
      ['Tickets (open)', String(openTickets)],
    ],
    styles: { fontSize: 9 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
    tableWidth: pageWidth / 2 - 12,
    margin: { left: 8 },
  });

  doc.setFontSize(12);
  doc.text('Assets by category', 8, doc.lastAutoTable.finalY + 10);
  autoTable(doc, {
    startY: doc.lastAutoTable.finalY + 13,
    head: [['Category', 'Count']],
    body: assetCountByCategory(assets).map((r) => [r.label, String(r.value)]),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
    tableWidth: pageWidth / 2 - 12,
    margin: { left: 8 },
  });

  doc.setFontSize(12);
  doc.text('Assets by status', 8, doc.lastAutoTable.finalY + 10);
  autoTable(doc, {
    startY: doc.lastAutoTable.finalY + 13,
    head: [['Status', 'Count']],
    body: assetCountByStatus(assets).map((r) => [r.label, String(r.value)]),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
    tableWidth: pageWidth / 2 - 12,
    margin: { left: 8 },
  });

  doc.setFontSize(12);
  doc.text('Tickets by status', 8, doc.lastAutoTable.finalY + 10);
  autoTable(doc, {
    startY: doc.lastAutoTable.finalY + 13,
    head: [['Status', 'Count']],
    body: countBy(tickets, 'status'),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
    tableWidth: pageWidth / 2 - 12,
    margin: { left: 8 },
  });

  doc.setFontSize(12);
  doc.text('Employees by status', 8, doc.lastAutoTable.finalY + 10);
  autoTable(doc, {
    startY: doc.lastAutoTable.finalY + 13,
    head: [['Status', 'Count']],
    body: countBy(employees, 'status'),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
    tableWidth: pageWidth / 2 - 12,
    margin: { left: 8 },
  });

  // Appendix: full asset and ticket listings, each starting a fresh page.
  doc.addPage();
  doc.setFontSize(13);
  doc.text('Appendix A — Full Asset Listing', 8, 12);
  autoTable(doc, {
    startY: 16,
    head: [ASSET_REPORT_COLUMNS.map((c) => c.label)],
    body: assetReportRows(assets, clients).map((r) => ASSET_REPORT_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 7 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });

  doc.addPage();
  doc.setFontSize(13);
  doc.text('Appendix B — Full Ticket Listing', 8, 12);
  autoTable(doc, {
    startY: 16,
    head: [TICKET_REPORT_COLUMNS.map((c) => c.label)],
    body: ticketReportRows(tickets, clients).map((r) => TICKET_REPORT_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 7 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });

  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

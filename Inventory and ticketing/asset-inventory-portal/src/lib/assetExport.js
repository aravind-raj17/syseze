import * as XLSX from 'xlsx';
import autoTable from 'jspdf-autotable';
import { toCSV, downloadBlob, sanitizeForSpreadsheet } from './csv';
import { CATEGORIES, STATUSES } from '../constants';
import { createBrandedDoc, addBrandedFooter, BRAND_TABLE_HEAD_STYLE } from './pdfBranding';

export const ASSET_COLUMNS = [
  { key: 'assetTag', label: 'Asset Tag' },
  { key: 'category', label: 'Category' },
  { key: 'brand', label: 'Brand' },
  { key: 'model', label: 'Model' },
  { key: 'serialNumber', label: 'Serial Number' },
  { key: 'purchaseDate', label: 'Purchase Date' },
  { key: 'warrantyExpiry', label: 'Warranty Expiry' },
  { key: 'location', label: 'Location' },
  { key: 'assignedTo', label: 'Assigned To' },
  { key: 'status', label: 'Status' },
  { key: 'notes', label: 'Notes' },
];

const TEMPLATE_HEADERS = ASSET_COLUMNS.map((c) => c.key);

export function downloadAssetTemplate() {
  const example = {
    assetTag: 'CMART-LAP-001',
    category: CATEGORIES[0],
    brand: 'Dell',
    model: 'Latitude 5440',
    serialNumber: 'DL5440-2291',
    purchaseDate: '2024-01-15',
    warrantyExpiry: '2027-01-15',
    location: 'HQ - Pune',
    assignedTo: 'Jane Doe',
    status: STATUSES[0],
    notes: '',
  };
  const csv = toCSV(TEMPLATE_HEADERS, [example]);
  downloadBlob(csv, 'asset-upload-template.csv', 'text/csv;charset=utf-8;');
}

function assetRows(assets) {
  return assets.map((a) => ({
    assetTag: a.assetTag,
    category: a.category,
    brand: a.brand || '',
    model: a.model || '',
    serialNumber: a.serialNumber || '',
    purchaseDate: a.purchaseDate || '',
    warrantyExpiry: a.warrantyExpiry || '',
    location: a.location || '',
    assignedTo: a.assignedTo || '',
    status: a.status,
    notes: a.notes || '',
  }));
}

export function exportAssetsCSV(assets, filenameBase) {
  const csv = toCSV(TEMPLATE_HEADERS, assetRows(assets));
  downloadBlob(csv, `${filenameBase}.csv`, 'text/csv;charset=utf-8;');
}

export function exportAssetsXLSX(assets, filenameBase) {
  const rows = assetRows(assets).map((r) => {
    const out = {};
    ASSET_COLUMNS.forEach((c) => { out[c.label] = sanitizeForSpreadsheet(r[c.key]); });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: ASSET_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Assets');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export async function exportAssetsPDF(assets, filenameBase, clientName) {
  const { doc, contentStartY } = await createBrandedDoc({
    title: clientName ? `${clientName} — Asset Inventory` : 'Asset Inventory',
    subtitle: `${assets.length} asset${assets.length === 1 ? '' : 's'}`,
  });

  autoTable(doc, {
    startY: contentStartY,
    head: [ASSET_COLUMNS.map((c) => c.label)],
    body: assetRows(assets).map((r) => ASSET_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 8 },
    headStyles: BRAND_TABLE_HEAD_STYLE,
  });

  addBrandedFooter(doc);
  doc.save(`${filenameBase}.pdf`);
}

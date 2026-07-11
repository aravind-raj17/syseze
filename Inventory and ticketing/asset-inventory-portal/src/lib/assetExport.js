import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';
import { toCSV, downloadBlob } from './csv';
import { CATEGORIES, STATUSES } from '../constants';

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
    ASSET_COLUMNS.forEach((c) => { out[c.label] = r[c.key]; });
    return out;
  });
  const worksheet = XLSX.utils.json_to_sheet(rows, { header: ASSET_COLUMNS.map((c) => c.label) });
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Assets');
  XLSX.writeFile(workbook, `${filenameBase}.xlsx`);
}

export function exportAssetsPDF(assets, filenameBase, clientName) {
  const doc = new jsPDF({ orientation: 'landscape' });
  doc.setFontSize(14);
  doc.text(clientName ? `${clientName} — Asset Inventory` : 'Asset Inventory', 14, 14);

  autoTable(doc, {
    startY: 20,
    head: [ASSET_COLUMNS.map((c) => c.label)],
    body: assetRows(assets).map((r) => ASSET_COLUMNS.map((c) => r[c.key])),
    styles: { fontSize: 8 },
    headStyles: { fillColor: [43, 37, 96] },
  });

  doc.save(`${filenameBase}.pdf`);
}

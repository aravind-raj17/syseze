import { parseCSV } from './csv';
import { CATEGORIES, STATUSES } from '../constants';

// Parses an uploaded CSV (matching the template from downloadAssetTemplate)
// into asset rows ready for Firestore, or a list of row-level errors.
export function parseAssetImportCSV(text, clientId) {
  const records = parseCSV(text);
  const valid = [];
  const errors = [];

  records.forEach((r, idx) => {
    const rowNum = idx + 2; // header is row 1
    const assetTag = (r.assetTag || '').trim();
    const category = (r.category || '').trim();
    const assignedTo = (r.assignedTo || '').trim();
    const status = (r.status || '').trim() || STATUSES[0];

    const problems = [];
    if (!assetTag) problems.push('missing Asset Tag');
    if (!category) problems.push('missing Category');
    else if (!CATEGORIES.includes(category)) problems.push(`unknown Category "${category}"`);
    if (!assignedTo) problems.push('missing Assigned To');
    if (status && !STATUSES.includes(status)) problems.push(`unknown Status "${status}"`);

    if (problems.length > 0) {
      errors.push({ row: rowNum, assetTag: assetTag || '(blank)', problems });
      return;
    }

    valid.push({
      clientId,
      assetTag,
      category,
      brand: r.brand || '',
      model: r.model || '',
      serialNumber: r.serialNumber || '',
      purchaseDate: r.purchaseDate || '',
      warrantyExpiry: r.warrantyExpiry || '',
      location: r.location || '',
      assignedTo,
      status,
      notes: r.notes || '',
    });
  });

  return { valid, errors };
}

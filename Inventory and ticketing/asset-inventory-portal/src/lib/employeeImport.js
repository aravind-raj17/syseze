import { parseCSV } from './csv';
import { EMPLOYEE_STATUSES } from '../employeeConstants';

// Parses an uploaded CSV (matching the template from downloadEmployeeTemplate)
// into employee rows ready for Firestore, or a list of row-level errors.
export function parseEmployeeImportCSV(text) {
  const records = parseCSV(text);
  const valid = [];
  const errors = [];

  records.forEach((r, idx) => {
    const rowNum = idx + 2; // header is row 1
    const name = (r.name || '').trim();
    const email = (r.email || '').trim();
    const status = (r.status || '').trim() || EMPLOYEE_STATUSES[0];

    const problems = [];
    if (!name) problems.push('missing Name');
    if (!email) problems.push('missing Email ID');
    if (status && !EMPLOYEE_STATUSES.includes(status)) problems.push(`unknown Status "${status}"`);

    if (problems.length > 0) {
      errors.push({ row: rowNum, name: name || '(blank)', problems });
      return;
    }

    valid.push({
      name,
      email,
      licenseAssigned: r.licenseAssigned || '',
      status,
    });
  });

  return { valid, errors };
}

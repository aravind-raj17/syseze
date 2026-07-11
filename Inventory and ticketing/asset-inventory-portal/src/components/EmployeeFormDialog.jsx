import { useEffect, useState } from 'react';
import { EMPLOYEE_STATUSES } from '../employeeConstants';

export default function EmployeeFormDialog({ open, title, organizationName, initialValues, saving, onSave, onClose }) {
  const [values, setValues] = useState(initialValues);
  const [error, setError] = useState('');

  useEffect(() => {
    if (open) {
      setValues(initialValues);
      setError('');
    }
  }, [open, initialValues]);

  if (!open) return null;

  const set = (field) => (e) => setValues((v) => ({ ...v, [field]: e.target.value }));

  const handleSave = () => {
    if (!values.name.trim() || !values.email.trim()) {
      setError('Name and Email ID are required.');
      return;
    }
    onSave(values);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" onClick={onClose}>
      <div
        role="dialog"
        aria-modal="true"
        className="w-full max-w-[480px] rounded-xl bg-white p-6 shadow-lg dark:bg-slate-900"
        onClick={(e) => e.stopPropagation()}
      >
        <h3 className="text-base font-semibold text-slate-900 dark:text-white">{title}</h3>
        <div className="mt-4 flex flex-col gap-4">
          <Field label="Name *">
            <input className="input" value={values.name} onChange={set('name')} />
          </Field>
          <Field label="Email ID *">
            <input type="email" className="input" value={values.email} onChange={set('email')} />
          </Field>
          <Field label="Organization Name">
            <p className="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400">
              {organizationName}
            </p>
          </Field>
          <Field label="License Assigned">
            <input className="input" placeholder="e.g. M365 E3" value={values.licenseAssigned} onChange={set('licenseAssigned')} />
          </Field>
          <Field label="Status">
            <select className="input" value={values.status} onChange={set('status')}>
              {EMPLOYEE_STATUSES.map((s) => <option key={s} value={s}>{s}</option>)}
            </select>
          </Field>
          {error && <p className="text-sm text-red-600 dark:text-red-400">{error}</p>}
        </div>
        <div className="mt-6 flex justify-end gap-2">
          <button
            type="button"
            onClick={onClose}
            className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
          >
            Cancel
          </button>
          <button
            type="button"
            onClick={handleSave}
            disabled={saving}
            className="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-60"
          >
            Save employee
          </button>
        </div>
      </div>
    </div>
  );
}

function Field({ label, children }) {
  return (
    <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
      {label}
      {children}
    </label>
  );
}

import { useEffect, useState } from 'react';

export default function ClientFormDialog({ open, title, initialValues, saving, onSave, onClose }) {
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
    if (!values.name.trim() || !values.code.trim()) {
      setError('Client Name and Client Code are required.');
      return;
    }
    onSave(values);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" onClick={onClose}>
      <div
        role="dialog"
        aria-modal="true"
        className="w-full max-w-[480px] rounded-xl bg-white p-6 shadow-lg"
        onClick={(e) => e.stopPropagation()}
      >
        <h3 className="text-base font-semibold text-slate-900">{title}</h3>
        <div className="mt-4 flex flex-col gap-4">
          <Field label="Client Name *">
            <input className="input" value={values.name} onChange={set('name')} />
          </Field>
          <div className="grid grid-cols-2 gap-3">
            <Field label="Client Code *">
              <input className="input" placeholder="e.g. CMART" value={values.code} onChange={set('code')} />
            </Field>
            <Field label="Contact Person">
              <input className="input" value={values.contactPerson} onChange={set('contactPerson')} />
            </Field>
          </div>
          <Field label="Contact Email">
            <input type="email" className="input" value={values.contactEmail} onChange={set('contactEmail')} />
          </Field>
          <Field label="Address">
            <input className="input" value={values.address} onChange={set('address')} />
          </Field>
          {error && <p className="text-sm text-red-600">{error}</p>}
        </div>
        <div className="mt-6 flex justify-end gap-2">
          <button
            type="button"
            onClick={onClose}
            className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
          >
            Cancel
          </button>
          <button
            type="button"
            onClick={handleSave}
            disabled={saving}
            className="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-60"
          >
            Save client
          </button>
        </div>
      </div>
    </div>
  );
}

function Field({ label, children }) {
  return (
    <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700">
      {label}
      {children}
    </label>
  );
}

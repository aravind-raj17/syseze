import { useEffect, useState } from 'react';
import { CATEGORIES, STATUSES } from '../constants';

export default function AssetFormSlideOver({ open, title, initialValues, clients, saving, onSave, onClose }) {
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
    if (!values.assetTag.trim() || !values.category || !values.clientId) {
      setError('Asset Tag, Category and Client are required.');
      return;
    }
    onSave(values);
  };

  return (
    <div className="fixed inset-0 z-40 flex justify-end bg-slate-900/50" onClick={onClose}>
      <div
        className="flex h-full w-full max-w-[460px] flex-col gap-4 overflow-y-auto bg-white p-6 shadow-xl"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex items-center justify-between">
          <h3 className="text-base font-semibold text-slate-900">{title}</h3>
          <button type="button" aria-label="Close" onClick={onClose} className="text-slate-400 hover:text-slate-600">
            ✕
          </button>
        </div>

        <Field label="Asset Tag *">
          <input className="input" placeholder="e.g. CMART-LAP-001" value={values.assetTag} onChange={set('assetTag')} />
        </Field>
        <Field label="Client *">
          <select className="input" value={values.clientId} onChange={set('clientId')}>
            <option value="">Select client…</option>
            {clients.map((c) => (
              <option key={c.id} value={c.id}>{c.name} ({c.code})</option>
            ))}
          </select>
        </Field>
        <Field label="Category *">
          <select className="input" value={values.category} onChange={set('category')}>
            {CATEGORIES.map((cat) => <option key={cat} value={cat}>{cat}</option>)}
          </select>
        </Field>
        <div className="grid grid-cols-2 gap-3">
          <Field label="Brand">
            <input className="input" value={values.brand} onChange={set('brand')} />
          </Field>
          <Field label="Model">
            <input className="input" value={values.model} onChange={set('model')} />
          </Field>
        </div>
        <Field label="Serial Number">
          <input className="input" value={values.serialNumber} onChange={set('serialNumber')} />
        </Field>
        <div className="grid grid-cols-2 gap-3">
          <Field label="Purchase Date">
            <input type="date" className="input" value={values.purchaseDate} onChange={set('purchaseDate')} />
          </Field>
          <Field label="Warranty Expiry">
            <input type="date" className="input" value={values.warrantyExpiry} onChange={set('warrantyExpiry')} />
          </Field>
        </div>
        <Field label="Location">
          <input className="input" placeholder="Site / building" value={values.location} onChange={set('location')} />
        </Field>
        <Field label="Assigned To">
          <input className="input" placeholder="Employee name (optional)" value={values.assignedTo} onChange={set('assignedTo')} />
        </Field>
        <Field label="Status">
          <select className="input" value={values.status} onChange={set('status')}>
            {STATUSES.map((st) => <option key={st} value={st}>{st}</option>)}
          </select>
        </Field>
        <Field label="Notes">
          <textarea rows={3} className="input" value={values.notes} onChange={set('notes')} />
        </Field>

        {error && <p className="text-sm text-red-600">{error}</p>}

        <div className="mt-2 flex justify-end gap-2">
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
            Save asset
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

import { useEffect, useState } from 'react';
import { ROLES, EMPTY_USER_FORM } from '../roleConstants';

export default function UserFormDialog({ open, saving, onSave, onClose }) {
  const [values, setValues] = useState(EMPTY_USER_FORM);
  const [error, setError] = useState('');

  useEffect(() => {
    if (open) {
      setValues(EMPTY_USER_FORM);
      setError('');
    }
  }, [open]);

  if (!open) return null;

  const set = (field) => (e) => setValues((v) => ({ ...v, [field]: e.target.value }));

  const handleSave = async () => {
    if (!values.name.trim() || !values.email.trim() || !values.password.trim()) {
      setError('Name, Email and Password are required.');
      return;
    }
    if (values.password.length < 6) {
      setError('Password must be at least 6 characters.');
      return;
    }
    try {
      await onSave(values);
    } catch (err) {
      setError(friendlyError(err.code));
    }
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" onClick={onClose}>
      <div
        role="dialog"
        aria-modal="true"
        className="w-full max-w-[440px] rounded-xl bg-white p-6 shadow-lg dark:bg-slate-900"
        onClick={(e) => e.stopPropagation()}
      >
        <h3 className="text-base font-semibold text-slate-900 dark:text-white">Create user</h3>
        <div className="mt-4 flex flex-col gap-4">
          <Field label="Name *">
            <input className="input" value={values.name} onChange={set('name')} />
          </Field>
          <Field label="Email *">
            <input type="email" className="input" value={values.email} onChange={set('email')} />
          </Field>
          <Field label="Password *">
            <input type="password" className="input" placeholder="At least 6 characters" value={values.password} onChange={set('password')} />
          </Field>
          <Field label="Access Level">
            <select className="input" value={values.role} onChange={set('role')}>
              {ROLES.map((r) => <option key={r} value={r}>{r === 'admin' ? 'Admin' : 'Standard'}</option>)}
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
            {saving ? 'Creating…' : 'Create user'}
          </button>
        </div>
      </div>
    </div>
  );
}

function friendlyError(code) {
  switch (code) {
    case 'auth/email-already-in-use':
      return 'An account with that email already exists.';
    case 'auth/invalid-email':
      return 'That email address looks invalid.';
    case 'auth/weak-password':
      return 'Password is too weak — use at least 6 characters.';
    default:
      return 'Something went wrong creating that user.';
  }
}

function Field({ label, children }) {
  return (
    <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
      {label}
      {children}
    </label>
  );
}

import { useEffect, useState } from 'react';
import { useClients } from '../hooks/useClients';
import { useClientAssets } from '../hooks/useClientAssets';
import { createTicket } from '../lib/tickets';
import {
  TICKET_TYPES,
  TICKET_CATEGORIES,
  REQUEST_SOURCES,
  URGENCY_LEVELS,
  IMPACT_LEVELS,
  EMPTY_TICKET_FORM,
  computePriority,
} from '../ticketConstants';
import TicketPriorityBadge from './TicketPriorityBadge';

export default function NewTicketDialog({ open, createdBy, defaultClientId, onClose, onCreated }) {
  const { clients } = useClients();
  const [values, setValues] = useState(EMPTY_TICKET_FORM);
  const [error, setError] = useState('');
  const [saving, setSaving] = useState(false);
  const { assets } = useClientAssets(values.clientId);

  useEffect(() => {
    if (open) {
      setValues({ ...EMPTY_TICKET_FORM, clientId: defaultClientId || '' });
      setError('');
    }
  }, [open, defaultClientId]);

  if (!open) return null;

  const set = (field) => (e) => {
    const value = e.target.value;
    setValues((v) => (field === 'clientId' ? { ...v, clientId: value, assetId: '' } : { ...v, [field]: value }));
  };

  const handleSave = async () => {
    if (!values.title.trim() || !values.clientId || !values.description.trim()) {
      setError('Title, Client and Description are required.');
      return;
    }
    setSaving(true);
    setError('');
    try {
      const ticketId = await createTicket(values, createdBy);
      onCreated(ticketId);
    } finally {
      setSaving(false);
    }
  };

  const priority = computePriority(values.urgency, values.impact);

  return (
    <div className="fixed inset-0 z-40 flex justify-end bg-slate-900/50" onClick={onClose}>
      <div
        className="flex h-full w-full max-w-[480px] flex-col gap-4 overflow-y-auto bg-white p-6 shadow-xl dark:bg-slate-900"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex items-center justify-between">
          <h3 className="text-base font-semibold text-slate-900 dark:text-white">New ticket</h3>
          <button type="button" aria-label="Close" onClick={onClose} className="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
            ✕
          </button>
        </div>

        <Field label="Title *">
          <input className="input" placeholder="Short summary of the issue" value={values.title} onChange={set('title')} />
        </Field>

        <Field label="Client *">
          <select className="input" value={values.clientId} onChange={set('clientId')}>
            <option value="">Select client…</option>
            {clients.map((c) => <option key={c.id} value={c.id}>{c.name} ({c.code})</option>)}
          </select>
        </Field>

        <Field label="Related asset (optional)">
          <select className="input" value={values.assetId} onChange={set('assetId')} disabled={!values.clientId}>
            <option value="">No specific asset</option>
            {assets.map((a) => <option key={a.id} value={a.id}>{a.assetTag} — {[a.brand, a.model].filter(Boolean).join(' ')}</option>)}
          </select>
        </Field>

        <div className="grid grid-cols-2 gap-3">
          <Field label="Type">
            <select className="input" value={values.type} onChange={set('type')}>
              {TICKET_TYPES.map((t) => <option key={t} value={t}>{t}</option>)}
            </select>
          </Field>
          <Field label="Category">
            <select className="input" value={values.category} onChange={set('category')}>
              {TICKET_CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
            </select>
          </Field>
        </div>

        <Field label="Description *">
          <textarea rows={4} className="input" placeholder="What's going on?" value={values.description} onChange={set('description')} />
        </Field>

        <div className="grid grid-cols-2 gap-3">
          <Field label="Urgency">
            <select className="input" value={values.urgency} onChange={set('urgency')}>
              {URGENCY_LEVELS.map((u) => <option key={u} value={u}>{u}</option>)}
            </select>
          </Field>
          <Field label="Impact">
            <select className="input" value={values.impact} onChange={set('impact')}>
              {IMPACT_LEVELS.map((i) => <option key={i} value={i}>{i}</option>)}
            </select>
          </Field>
        </div>

        <div className="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
          Priority: <TicketPriorityBadge priority={priority} />
        </div>

        <Field label="Location">
          <input className="input" placeholder="Site / building" value={values.location} onChange={set('location')} />
        </Field>

        <Field label="Request source">
          <select className="input" value={values.source} onChange={set('source')}>
            {REQUEST_SOURCES.map((s) => <option key={s} value={s}>{s}</option>)}
          </select>
        </Field>

        <Field label="Assigned to (optional)">
          <input className="input" placeholder="Staff email" value={values.assignedTo} onChange={set('assignedTo')} />
        </Field>

        <Field label="Observers (optional)">
          <input className="input" placeholder="Comma-separated emails" value={values.observers} onChange={set('observers')} />
        </Field>

        {error && <p className="text-sm text-red-600 dark:text-red-400">{error}</p>}

        <div className="mt-2 flex justify-end gap-2">
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
            {saving ? 'Creating…' : 'Create ticket'}
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

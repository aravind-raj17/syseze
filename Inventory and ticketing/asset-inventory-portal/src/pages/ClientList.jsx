import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useClients } from '../hooks/useClients';
import { createClient, updateClient, setClientActive } from '../lib/firestore';
import { EMPTY_CLIENT_FORM } from '../constants';
import ClientFormDialog from '../components/ClientFormDialog';
import ConfirmDialog from '../components/ConfirmDialog';

export default function ClientList() {
  const navigate = useNavigate();
  const { clients, loading } = useClients();
  const [formOpen, setFormOpen] = useState(false);
  const [editingClient, setEditingClient] = useState(null);
  const [toggleTarget, setToggleTarget] = useState(null);
  const [saving, setSaving] = useState(false);

  const openNew = () => {
    setEditingClient(null);
    setFormOpen(true);
  };
  const openEdit = (client) => {
    setEditingClient(client);
    setFormOpen(true);
  };

  const handleSave = async (values) => {
    setSaving(true);
    try {
      if (editingClient) {
        await updateClient(editingClient.id, values);
      } else {
        await createClient(values);
      }
      setFormOpen(false);
    } finally {
      setSaving(false);
    }
  };

  const handleToggleConfirm = async () => {
    await setClientActive(toggleTarget.id, !toggleTarget.active);
    setToggleTarget(null);
  };

  return (
    <div className="mx-auto flex max-w-[1000px] flex-col gap-4 p-6">
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Client management</h1>
          <p className="text-sm text-slate-500 dark:text-slate-400">Add clients and keep their contact details current.</p>
        </div>
        <button
          type="button"
          onClick={openNew}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          + Add client
        </button>
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading clients…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="px-4 py-3">Client</th>
                <th className="px-4 py-3">Code</th>
                <th className="px-4 py-3">Contact</th>
                <th className="px-4 py-3">Email</th>
                <th className="px-4 py-3">Status</th>
                <th className="px-4 py-3" />
              </tr>
            </thead>
            <tbody>
              {clients.map((c) => (
                <tr key={c.id} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
                  <td className="px-4 py-3">
                    <button
                      type="button"
                      onClick={() => navigate(`/clients/${c.id}`)}
                      className="font-medium text-slate-900 hover:text-blue-600 hover:underline dark:text-white dark:hover:text-blue-400"
                    >
                      {c.name}
                    </button>
                  </td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{c.code}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{c.contactPerson}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{c.contactEmail}</td>
                  <td className="px-4 py-3">
                    <span
                      className={`rounded-full px-2.5 py-0.5 text-xs font-medium ${
                        c.active
                          ? 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400'
                          : 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300'
                      }`}
                    >
                      {c.active ? 'Active' : 'Inactive'}
                    </span>
                  </td>
                  <td className="px-4 py-3">
                    <div className="flex justify-end gap-2">
                      <button
                        type="button"
                        onClick={() => navigate(`/clients/${c.id}`)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        View assets
                      </button>
                      <button
                        type="button"
                        onClick={() => navigate(`/clients/${c.id}/employees`)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        View employees
                      </button>
                      <button
                        type="button"
                        onClick={() => openEdit(c)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        Edit
                      </button>
                      <button
                        type="button"
                        onClick={() => setToggleTarget(c)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        {c.active ? 'Deactivate' : 'Reactivate'}
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && clients.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No clients yet — add your first one.</p>
      )}

      <ClientFormDialog
        open={formOpen}
        title={editingClient ? 'Edit client' : 'Add client'}
        initialValues={
          editingClient
            ? {
                name: editingClient.name,
                code: editingClient.code,
                contactPerson: editingClient.contactPerson,
                contactEmail: editingClient.contactEmail,
                address: editingClient.address,
              }
            : EMPTY_CLIENT_FORM
        }
        saving={saving}
        onSave={handleSave}
        onClose={() => setFormOpen(false)}
      />

      <ConfirmDialog
        open={!!toggleTarget}
        title={toggleTarget ? (toggleTarget.active ? `Deactivate ${toggleTarget.name}?` : `Reactivate ${toggleTarget.name}?`) : ''}
        body={
          toggleTarget
            ? toggleTarget.active
              ? 'Their assets stay in the system, but the client will be hidden from active dashboards.'
              : 'The client will reappear on active dashboards.'
            : ''
        }
        confirmLabel={toggleTarget?.active ? 'Deactivate' : 'Reactivate'}
        onConfirm={handleToggleConfirm}
        onCancel={() => setToggleTarget(null)}
      />
    </div>
  );
}

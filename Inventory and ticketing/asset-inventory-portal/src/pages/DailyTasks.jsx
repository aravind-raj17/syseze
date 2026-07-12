import { useMemo, useState } from 'react';
import { useAuth } from '../auth/AuthContext';
import { useClients } from '../hooks/useClients';
import { useDailyTasks } from '../hooks/useDailyTasks';
import { createDailyTask, deleteDailyTask } from '../lib/dailyTasks';
import { exportDailyTasksCSV, exportDailyTasksXLSX, exportDailyTasksPDF } from '../lib/dailyTaskExport';
import { EMPTY_DAILY_TASK_FORM } from '../dailyTaskConstants';
import ConfirmDialog from '../components/ConfirmDialog';
import ExportMenu from '../components/ExportMenu';

export default function DailyTasks() {
  const { currentUser, isAdmin } = useAuth();
  const { clients } = useClients();
  const { tasks, loading } = useDailyTasks(isAdmin, currentUser?.email);

  const [form, setForm] = useState(EMPTY_DAILY_TASK_FORM);
  const [error, setError] = useState('');
  const [saving, setSaving] = useState(false);
  const [staffFilter, setStaffFilter] = useState('All');
  const [clientFilter, setClientFilter] = useState('All');
  const [deleteTarget, setDeleteTarget] = useState(null);

  const set = (field) => (e) => setForm((v) => ({ ...v, [field]: e.target.value }));

  const staffOptions = useMemo(
    () => [...new Set(tasks.map((t) => t.createdByName).filter(Boolean))].sort(),
    [tasks]
  );

  const filtered = useMemo(() => {
    let list = tasks;
    if (isAdmin && staffFilter !== 'All') list = list.filter((t) => t.createdByName === staffFilter);
    if (isAdmin && clientFilter !== 'All') list = list.filter((t) => t.clientId === clientFilter);
    return list;
  }, [tasks, isAdmin, staffFilter, clientFilter]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!form.clientId || !form.issuesAttended.trim()) {
      setError('Client and Issues Attended are required.');
      return;
    }
    setError('');
    setSaving(true);
    try {
      const client = clients.find((c) => c.id === form.clientId);
      await createDailyTask({ ...form, clientName: client?.name || '' }, currentUser);
      setForm(EMPTY_DAILY_TASK_FORM);
    } finally {
      setSaving(false);
    }
  };

  const handleDeleteConfirm = async () => {
    await deleteDailyTask(deleteTarget.id);
    setDeleteTarget(null);
  };

  const exportFilenameBase = `daily-tasks-${new Date().toISOString().slice(0, 10)}`;

  return (
    <div className="mx-auto flex max-w-[1100px] flex-col gap-6 p-6">
      <div>
        <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Daily tasks</h1>
        <p className="text-sm text-slate-500 dark:text-slate-400">
          {isAdmin ? 'Log your own visits, and review every staff member\'s entries.' : 'Log the clients you visited today.'}
        </p>
      </div>

      <form onSubmit={handleSubmit} className="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
            Client *
            <select className="input" value={form.clientId} onChange={set('clientId')}>
              <option value="">Select client…</option>
              {clients.map((c) => <option key={c.id} value={c.id}>{c.name} ({c.code})</option>)}
            </select>
          </label>
          <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
            Login time
            <input type="time" className="input" value={form.loginTime} onChange={set('loginTime')} />
          </label>
          <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
            Logout time
            <input type="time" className="input" value={form.logoutTime} onChange={set('logoutTime')} />
          </label>
        </div>
        <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
          Issues attended *
          <textarea rows={3} className="input" value={form.issuesAttended} onChange={set('issuesAttended')} />
        </label>
        {error && <p className="text-sm text-red-600 dark:text-red-400">{error}</p>}
        <button
          type="submit"
          disabled={saving}
          className="self-start rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-60"
        >
          {saving ? 'Saving…' : 'Add daily task'}
        </button>
      </form>

      <div className="flex flex-wrap items-center justify-between gap-3">
        {isAdmin ? (
          <div className="flex flex-wrap gap-3">
            <select className="input w-auto min-w-[170px]" value={staffFilter} onChange={(e) => setStaffFilter(e.target.value)}>
              <option value="All">All staff</option>
              {staffOptions.map((name) => <option key={name} value={name}>{name}</option>)}
            </select>
            <select className="input w-auto min-w-[170px]" value={clientFilter} onChange={(e) => setClientFilter(e.target.value)}>
              <option value="All">All clients</option>
              {clients.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
            </select>
          </div>
        ) : <div />}
        {isAdmin && (
          <ExportMenu
            disabled={filtered.length === 0}
            options={[
              { label: 'CSV', onSelect: () => exportDailyTasksCSV(filtered, exportFilenameBase) },
              { label: 'Excel (.xlsx)', onSelect: () => exportDailyTasksXLSX(filtered, exportFilenameBase) },
              { label: 'PDF', onSelect: () => exportDailyTasksPDF(filtered, exportFilenameBase, 'Daily Tasks') },
            ]}
          />
        )}
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading entries…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="px-4 py-3">Date</th>
                {isAdmin && <th className="px-4 py-3">Staff</th>}
                <th className="px-4 py-3">Client</th>
                <th className="px-4 py-3">Issues Attended</th>
                <th className="px-4 py-3">Login</th>
                <th className="px-4 py-3">Logout</th>
                {isAdmin && <th className="px-4 py-3" />}
              </tr>
            </thead>
            <tbody>
              {filtered.map((t) => (
                <tr key={t.id} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{t.date}</td>
                  {isAdmin && <td className="px-4 py-3 dark:text-slate-200">{t.createdByName}</td>}
                  <td className="px-4 py-3 dark:text-slate-200">{t.clientName}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{t.issuesAttended}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{t.loginTime || '—'}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{t.logoutTime || '—'}</td>
                  {isAdmin && (
                    <td className="px-4 py-3">
                      <div className="flex justify-end">
                        <button
                          type="button"
                          onClick={() => setDeleteTarget(t)}
                          className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                          Delete
                        </button>
                      </div>
                    </td>
                  )}
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && filtered.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No daily task entries yet.</p>
      )}

      <ConfirmDialog
        open={!!deleteTarget}
        title="Delete this entry?"
        body={deleteTarget ? `The daily task for "${deleteTarget.clientName}" on ${deleteTarget.date} will be permanently removed.` : ''}
        confirmLabel="Delete"
        onConfirm={handleDeleteConfirm}
        onCancel={() => setDeleteTarget(null)}
      />
    </div>
  );
}

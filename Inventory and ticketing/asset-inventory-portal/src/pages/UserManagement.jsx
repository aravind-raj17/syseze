import { useState } from 'react';
import { useUsers } from '../hooks/useUsers';
import { createUserWithRole } from '../lib/users';
import { useAuth } from '../auth/AuthContext';
import UserFormDialog from '../components/UserFormDialog';

export default function UserManagement() {
  const { currentUser } = useAuth();
  const { users, loading } = useUsers();
  const [formOpen, setFormOpen] = useState(false);
  const [saving, setSaving] = useState(false);
  const [notice, setNotice] = useState('');

  const handleSave = async (values) => {
    setSaving(true);
    try {
      await createUserWithRole(values, currentUser.email);
      setNotice(`Created ${values.email}.`);
      setTimeout(() => setNotice(''), 5000);
      setFormOpen(false);
    } finally {
      setSaving(false);
    }
  };

  return (
    <div className="mx-auto flex max-w-[900px] flex-col gap-4 p-6">
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 className="text-xl font-semibold text-slate-900 dark:text-white">User management</h1>
          <p className="text-sm text-slate-500 dark:text-slate-400">Create staff logins and control who has admin access.</p>
        </div>
        <button
          type="button"
          onClick={() => setFormOpen(true)}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          + Create user
        </button>
      </div>

      {notice && (
        <p className="rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
          {notice}
        </p>
      )}

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading users…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="px-4 py-3">Name</th>
                <th className="px-4 py-3">Email</th>
                <th className="px-4 py-3">Access Level</th>
              </tr>
            </thead>
            <tbody>
              {users.map((u) => (
                <tr key={u.id} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
                  <td className="px-4 py-3 font-medium text-slate-900 dark:text-white">{u.name}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{u.email}</td>
                  <td className="px-4 py-3">
                    <span
                      className={`rounded-full px-2.5 py-0.5 text-xs font-medium ${
                        u.role === 'admin'
                          ? 'bg-violet-100 text-violet-700 dark:bg-violet-500/15 dark:text-violet-400'
                          : 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300'
                      }`}
                    >
                      {u.role === 'admin' ? 'Admin' : 'Standard'}
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && users.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No users yet.</p>
      )}

      <UserFormDialog open={formOpen} saving={saving} onSave={handleSave} onClose={() => setFormOpen(false)} />
    </div>
  );
}

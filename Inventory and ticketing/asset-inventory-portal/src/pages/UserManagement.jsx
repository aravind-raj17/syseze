import { useState } from 'react';
import { useUsers } from '../hooks/useUsers';
import { createUserWithRole, setUserActive, sendPasswordReset } from '../lib/users';
import { useAuth } from '../auth/AuthContext';
import UserFormDialog from '../components/UserFormDialog';
import ConfirmDialog from '../components/ConfirmDialog';

export default function UserManagement() {
  const { currentUser } = useAuth();
  const { users, loading } = useUsers();
  const [formOpen, setFormOpen] = useState(false);
  const [saving, setSaving] = useState(false);
  const [notice, setNotice] = useState('');
  const [toggleTarget, setToggleTarget] = useState(null);

  const showNotice = (message) => {
    setNotice(message);
    setTimeout(() => setNotice(''), 5000);
  };

  const handleSave = async (values) => {
    setSaving(true);
    try {
      await createUserWithRole(values, currentUser.email);
      showNotice(`Created ${values.email}.`);
      setFormOpen(false);
    } finally {
      setSaving(false);
    }
  };

  const handleToggleConfirm = async () => {
    await setUserActive(toggleTarget.id, !(toggleTarget.active !== false));
    showNotice(`${toggleTarget.active !== false ? 'Deactivated' : 'Reactivated'} ${toggleTarget.email}.`);
    setToggleTarget(null);
  };

  const handlePasswordReset = async (user) => {
    await sendPasswordReset(user.email);
    showNotice(`Password reset email sent to ${user.email}.`);
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
                <th className="px-4 py-3">Status</th>
                <th className="px-4 py-3" />
              </tr>
            </thead>
            <tbody>
              {users.map((u) => {
                const isActive = u.active !== false;
                const isSelf = u.id === currentUser.uid;
                return (
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
                    <td className="px-4 py-3">
                      <span
                        className={`rounded-full px-2.5 py-0.5 text-xs font-medium ${
                          isActive
                            ? 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400'
                            : 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400'
                        }`}
                      >
                        {isActive ? 'Active' : 'Deactivated'}
                      </span>
                    </td>
                    <td className="px-4 py-3">
                      <div className="flex justify-end gap-2">
                        <button
                          type="button"
                          onClick={() => handlePasswordReset(u)}
                          className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                          Reset password
                        </button>
                        <button
                          type="button"
                          disabled={isSelf}
                          title={isSelf ? "You can't deactivate your own account" : undefined}
                          onClick={() => setToggleTarget(u)}
                          className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                          {isActive ? 'Deactivate' : 'Reactivate'}
                        </button>
                      </div>
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
      )}

      {!loading && users.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No users yet.</p>
      )}

      <UserFormDialog open={formOpen} saving={saving} onSave={handleSave} onClose={() => setFormOpen(false)} />

      <ConfirmDialog
        open={!!toggleTarget}
        title={toggleTarget ? `${toggleTarget.active !== false ? 'Deactivate' : 'Reactivate'} ${toggleTarget.name}?` : ''}
        body={
          toggleTarget?.active !== false
            ? "They'll be signed out immediately and can no longer log in until reactivated."
            : 'They\'ll be able to log in again.'
        }
        confirmLabel={toggleTarget?.active !== false ? 'Deactivate' : 'Reactivate'}
        onConfirm={handleToggleConfirm}
        onCancel={() => setToggleTarget(null)}
      />
    </div>
  );
}

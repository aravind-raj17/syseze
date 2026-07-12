import { useState } from 'react';

const TYPE_STYLES = {
  description: 'bg-green-50 border-green-200 dark:bg-green-500/10 dark:border-green-500/20',
  followup: 'bg-slate-50 border-slate-200 dark:bg-slate-800/60 dark:border-slate-700',
};

function formatDateTime(ts) {
  if (!ts?.toDate) return '';
  return ts.toDate().toLocaleString();
}

export default function TicketTimelineItem({ type, author, createdAt, editedAt, content, canEdit, canDelete, onEdit, onDelete }) {
  const [editing, setEditing] = useState(false);
  const [draft, setDraft] = useState(content);

  const startEdit = () => {
    setDraft(content);
    setEditing(true);
  };

  const saveEdit = async () => {
    if (!draft.trim()) return;
    await onEdit(draft.trim());
    setEditing(false);
  };

  return (
    <div className={`rounded-lg border p-4 ${TYPE_STYLES[type] || TYPE_STYLES.followup}`}>
      <div className="mb-2 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <span className="font-medium text-slate-700 dark:text-slate-200">{author}</span>
        <span>·</span>
        <span>{formatDateTime(createdAt)}</span>
        {editedAt && <span className="italic">(edited)</span>}
        {(canEdit || canDelete) && !editing && (
          <span className="ml-auto flex gap-2">
            {canEdit && (
              <button type="button" onClick={startEdit} className="text-blue-600 hover:underline dark:text-blue-400">
                Edit
              </button>
            )}
            {canDelete && (
              <button type="button" onClick={onDelete} className="text-red-600 hover:underline dark:text-red-400">
                Delete
              </button>
            )}
          </span>
        )}
      </div>

      {editing ? (
        <div className="flex flex-col gap-2">
          <textarea
            rows={3}
            value={draft}
            onChange={(e) => setDraft(e.target.value)}
            className="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
          />
          <div className="flex justify-end gap-2">
            <button
              type="button"
              onClick={() => setEditing(false)}
              className="rounded-lg border border-slate-300 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
            >
              Cancel
            </button>
            <button
              type="button"
              onClick={saveEdit}
              className="rounded-lg bg-blue-600 px-3 py-1 text-xs font-medium text-white hover:bg-blue-700"
            >
              Save
            </button>
          </div>
        </div>
      ) : (
        <p className="whitespace-pre-wrap text-sm text-slate-800 dark:text-slate-100">{content}</p>
      )}
    </div>
  );
}

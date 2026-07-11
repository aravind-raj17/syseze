const TYPE_STYLES = {
  description: 'bg-green-50 border-green-200 dark:bg-green-500/10 dark:border-green-500/20',
  followup: 'bg-slate-50 border-slate-200 dark:bg-slate-800/60 dark:border-slate-700',
};

function formatDateTime(ts) {
  if (!ts?.toDate) return '';
  return ts.toDate().toLocaleString();
}

export default function TicketTimelineItem({ type, author, createdAt, content }) {
  return (
    <div className={`rounded-lg border p-4 ${TYPE_STYLES[type] || TYPE_STYLES.followup}`}>
      <div className="mb-2 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <span className="font-medium text-slate-700 dark:text-slate-200">{author}</span>
        <span>·</span>
        <span>{formatDateTime(createdAt)}</span>
      </div>
      <p className="whitespace-pre-wrap text-sm text-slate-800 dark:text-slate-100">{content}</p>
    </div>
  );
}

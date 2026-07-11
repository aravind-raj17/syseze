const TYPE_STYLES = {
  description: 'bg-green-50 border-green-200 dark:bg-green-500/10 dark:border-green-500/20',
  followup: 'bg-slate-50 border-slate-200 dark:bg-slate-800/60 dark:border-slate-700',
};

function formatDateTime(ts) {
  if (!ts?.toDate) return '';
  return ts.toDate().toLocaleString();
}

function formatSize(bytes) {
  if (!bytes) return '';
  const kio = bytes / 1024;
  return kio > 1024 ? `${(kio / 1024).toFixed(2)} Mio` : `${kio.toFixed(2)} Kio`;
}

export default function TicketTimelineItem({ type, author, createdAt, content, attachments = [] }) {
  return (
    <div className={`rounded-lg border p-4 ${TYPE_STYLES[type] || TYPE_STYLES.followup}`}>
      <div className="mb-2 flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <span className="font-medium text-slate-700 dark:text-slate-200">{author}</span>
        <span>·</span>
        <span>{formatDateTime(createdAt)}</span>
      </div>
      <p className="whitespace-pre-wrap text-sm text-slate-800 dark:text-slate-100">{content}</p>
      {attachments.length > 0 && (
        <ul className="mt-3 flex flex-col gap-1">
          {attachments.map((a) => (
            <li key={a.url} className="text-sm">
              <a
                href={a.url}
                target="_blank"
                rel="noreferrer"
                className="text-blue-600 hover:underline dark:text-blue-400"
              >
                {a.name}
              </a>
              <span className="ml-2 text-xs text-slate-400">{formatSize(a.size)}</span>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

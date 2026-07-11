const STYLES = {
  New: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400',
  Processing: 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400',
  Pending: 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-400',
  Solved: 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400',
  Closed: 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
};

export default function TicketStatusBadge({ status }) {
  return (
    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${STYLES[status] || STYLES.New}`}>
      {status}
    </span>
  );
}

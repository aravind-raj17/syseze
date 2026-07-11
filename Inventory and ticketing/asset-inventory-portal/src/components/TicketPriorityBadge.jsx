const STYLES = {
  Low: 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
  Medium: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400',
  High: 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-400',
  'Very High': 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',
};

export default function TicketPriorityBadge({ priority }) {
  return (
    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${STYLES[priority] || STYLES.Medium}`}>
      {priority}
    </span>
  );
}

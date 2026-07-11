const STYLES = {
  Active: 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400',
  Available: 'bg-teal-100 text-teal-700 dark:bg-teal-500/15 dark:text-teal-400',
  'In Repair': 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
  Retired: 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
  Spare: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400',
};

export default function StatusBadge({ status }) {
  return (
    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${STYLES[status] || STYLES.Retired}`}>
      {status}
    </span>
  );
}

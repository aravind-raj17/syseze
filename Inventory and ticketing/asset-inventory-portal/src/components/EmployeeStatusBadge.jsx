const STYLES = {
  Active: 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400',
  Disable: 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
  Delete: 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',
  Retain: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400',
};

export default function EmployeeStatusBadge({ status }) {
  return (
    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${STYLES[status] || STYLES.Active}`}>
      {status}
    </span>
  );
}

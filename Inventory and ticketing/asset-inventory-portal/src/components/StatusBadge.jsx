const STYLES = {
  Active: 'bg-green-100 text-green-700',
  'In Repair': 'bg-yellow-100 text-yellow-700',
  Retired: 'bg-slate-200 text-slate-600',
  Spare: 'bg-blue-100 text-blue-700',
};

export default function StatusBadge({ status }) {
  return (
    <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${STYLES[status] || STYLES.Retired}`}>
      {status}
    </span>
  );
}

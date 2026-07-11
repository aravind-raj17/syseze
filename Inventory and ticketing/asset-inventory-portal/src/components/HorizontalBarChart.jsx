// Magnitude comparison (which category/client has more assets) is a
// sequential job, not identity — one hue, length encodes value, per the
// dataviz skill's form guidance. Value sits at the bar's tip.
export default function HorizontalBarChart({ title, rows }) {
  const sorted = [...rows].sort((a, b) => b.value - a.value);
  const max = Math.max(1, ...sorted.map((r) => r.value));

  return (
    <div className="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
      {title && <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">{title}</h3>}
      <div className="flex flex-col gap-2.5">
        {sorted.map((r) => (
          <div key={r.label} className="flex items-center gap-3" title={`${r.label}: ${r.value}`}>
            <span className="w-28 shrink-0 truncate text-sm text-slate-600 dark:text-slate-300">{r.label}</span>
            <div className="h-4 flex-1 rounded-full bg-slate-100 dark:bg-slate-800">
              <div
                className="h-4 rounded-full bg-blue-600 dark:bg-blue-500"
                style={{ width: `${(r.value / max) * 100}%` }}
              />
            </div>
            <span className="w-8 shrink-0 text-right text-sm font-medium text-slate-900 dark:text-white">{r.value}</span>
          </div>
        ))}
        {sorted.length === 0 && <p className="text-sm text-slate-500 dark:text-slate-400">No data yet.</p>}
      </div>
    </div>
  );
}

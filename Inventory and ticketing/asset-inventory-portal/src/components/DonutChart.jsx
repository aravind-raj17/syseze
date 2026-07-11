// Hand-rolled SVG donut (no charting dependency) — per the dataviz skill's
// mark spec: a 2px surface gap between touching segments, direct labels via
// the legend (never color-alone identity), and a center total figure.
const SIZE = 160;
const STROKE = 22;
const RADIUS = (SIZE - STROKE) / 2;
const CIRCUMFERENCE = 2 * Math.PI * RADIUS;
const GAP_PX = 3;

export default function DonutChart({ title, segments, totalLabel = 'Total' }) {
  const total = segments.reduce((sum, s) => sum + s.value, 0);
  let cumulative = 0;

  return (
    <div className="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900 sm:flex-row sm:items-center">
      <div className="relative mx-auto shrink-0" style={{ width: SIZE, height: SIZE }}>
        <svg width={SIZE} height={SIZE} viewBox={`0 0 ${SIZE} ${SIZE}`} className="-rotate-90">
          <circle
            cx={SIZE / 2}
            cy={SIZE / 2}
            r={RADIUS}
            fill="none"
            stroke="currentColor"
            strokeWidth={STROKE}
            className="text-slate-100 dark:text-slate-800"
          />
          {total > 0 &&
            segments
              .filter((s) => s.value > 0)
              .map((s) => {
                const fraction = s.value / total;
                const segLen = Math.max(fraction * CIRCUMFERENCE - GAP_PX, 0);
                const offset = -cumulative;
                cumulative += fraction * CIRCUMFERENCE;
                return (
                  <circle
                    key={s.label}
                    cx={SIZE / 2}
                    cy={SIZE / 2}
                    r={RADIUS}
                    fill="none"
                    stroke={s.color}
                    strokeWidth={STROKE}
                    strokeDasharray={`${segLen} ${CIRCUMFERENCE - segLen}`}
                    strokeDashoffset={offset}
                    strokeLinecap="butt"
                  >
                    <title>{`${s.label}: ${s.value} (${Math.round(fraction * 100)}%)`}</title>
                  </circle>
                );
              })}
        </svg>
        <div className="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
          <span className="text-2xl font-semibold text-slate-900 dark:text-white">{total.toLocaleString()}</span>
          <span className="text-xs text-slate-500 dark:text-slate-400">{totalLabel}</span>
        </div>
      </div>

      <div className="flex-1">
        {title && <h3 className="mb-2 text-sm font-semibold text-slate-900 dark:text-white">{title}</h3>}
        <ul className="flex flex-col gap-1.5">
          {segments.map((s) => (
            <li key={s.label} className="flex items-center gap-2 text-sm">
              <span className="h-2.5 w-2.5 shrink-0 rounded-full" style={{ backgroundColor: s.color }} />
              <span className="flex-1 text-slate-600 dark:text-slate-300">{s.label}</span>
              <span className="font-medium text-slate-900 dark:text-white">{s.value.toLocaleString()}</span>
              <span className="w-10 text-right text-xs text-slate-400">
                {total > 0 ? `${Math.round((s.value / total) * 100)}%` : '—'}
              </span>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
}

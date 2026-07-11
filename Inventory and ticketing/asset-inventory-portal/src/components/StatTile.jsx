// Tile background/icon colors — one step off the dataviz skill's categorical
// palette, translated to Tailwind's ramp. Tiles carry an icon + label as the
// real identity channel, so hue reuse across tiles (as GLPI's own dashboard
// does) is fine here — this isn't a shared-legend chart.
const TILE_COLORS = {
  blue: 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
  aqua: 'bg-teal-50 text-teal-700 dark:bg-teal-500/10 dark:text-teal-400',
  yellow: 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
  green: 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
  violet: 'bg-violet-50 text-violet-700 dark:bg-violet-500/10 dark:text-violet-400',
  red: 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
  magenta: 'bg-pink-50 text-pink-700 dark:bg-pink-500/10 dark:text-pink-400',
  orange: 'bg-orange-50 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400',
};

export default function StatTile({ label, value, icon: Icon, color = 'blue' }) {
  return (
    <div className={`flex flex-col gap-3 rounded-xl p-4 ${TILE_COLORS[color] || TILE_COLORS.blue}`}>
      <div className="flex items-center justify-between">
        <span className="text-sm font-medium">{label}</span>
        {Icon && <Icon className="h-5 w-5 opacity-70" />}
      </div>
      <span className="text-3xl font-semibold">{value.toLocaleString()}</span>
    </div>
  );
}

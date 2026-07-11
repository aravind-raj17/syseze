import { useTheme } from '../theme/ThemeContext';

const OPTIONS = [
  { value: 'light', label: 'Light' },
  { value: 'dark', label: 'Dark' },
  { value: 'system', label: 'Device' },
];

export default function ThemeToggle() {
  const { mode, setTheme } = useTheme();

  return (
    <div className="flex items-center gap-0.5 rounded-lg border border-slate-300 bg-white p-0.5 dark:border-slate-700 dark:bg-slate-800">
      {OPTIONS.map((opt) => (
        <button
          key={opt.value}
          type="button"
          onClick={() => setTheme(opt.value)}
          aria-pressed={mode === opt.value}
          className={`rounded-md px-2 py-1 text-xs font-medium transition ${
            mode === opt.value
              ? 'bg-blue-600 text-white'
              : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100'
          }`}
        >
          {opt.label}
        </button>
      ))}
    </div>
  );
}

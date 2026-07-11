import { createContext, useCallback, useContext, useEffect, useMemo, useState } from 'react';

const ThemeContext = createContext(null);
const STORAGE_KEY = 'asset-portal-theme';

function getSystemPrefersDark() {
  return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function resolveTheme(mode) {
  if (mode === 'system') return getSystemPrefersDark() ? 'dark' : 'light';
  return mode;
}

function applyResolvedTheme(resolved) {
  document.documentElement.classList.toggle('dark', resolved === 'dark');
}

export function ThemeProvider({ children }) {
  const [mode, setMode] = useState(() => localStorage.getItem(STORAGE_KEY) || 'system');
  const [resolved, setResolved] = useState(() => resolveTheme(mode));

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, mode);
    const next = resolveTheme(mode);
    setResolved(next);
    applyResolvedTheme(next);

    if (mode !== 'system') return undefined;
    const mql = window.matchMedia('(prefers-color-scheme: dark)');
    const onChange = () => {
      const sys = mql.matches ? 'dark' : 'light';
      setResolved(sys);
      applyResolvedTheme(sys);
    };
    mql.addEventListener('change', onChange);
    return () => mql.removeEventListener('change', onChange);
  }, [mode]);

  const setTheme = useCallback((next) => setMode(next), []);

  const value = useMemo(() => ({ mode, resolved, setTheme }), [mode, resolved, setTheme]);

  return <ThemeContext.Provider value={value}>{children}</ThemeContext.Provider>;
}

export function useTheme() {
  return useContext(ThemeContext);
}

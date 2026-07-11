import { NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../auth/AuthContext';
import Logo from './Logo';
import ThemeToggle from './ThemeToggle';

export default function Navbar() {
  const { currentUser, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login', { replace: true });
  };

  const linkClass = ({ isActive }) =>
    `text-sm font-medium ${
      isActive
        ? 'text-slate-900 dark:text-white'
        : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100'
    }`;

  return (
    <nav className="flex items-center gap-6 border-b border-slate-200 bg-white px-6 py-3 dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <Logo className="h-8" />
        <span className="hidden text-sm font-semibold text-slate-900 sm:inline dark:text-white">
          Asset Inventory Portal
        </span>
      </div>
      <NavLink to="/dashboard" className={linkClass}>Dashboard</NavLink>
      <NavLink to="/clients" className={linkClass}>Clients</NavLink>
      <NavLink to="/tickets" className={linkClass}>Tickets</NavLink>
      <span className="ml-auto hidden text-sm text-slate-500 sm:inline dark:text-slate-400">{currentUser?.email}</span>
      <ThemeToggle />
      <button
        type="button"
        onClick={handleLogout}
        className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
      >
        Sign out
      </button>
    </nav>
  );
}

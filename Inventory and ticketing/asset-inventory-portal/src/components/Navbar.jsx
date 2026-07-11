import { NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../auth/AuthContext';

export default function Navbar() {
  const { currentUser, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login', { replace: true });
  };

  const linkClass = ({ isActive }) =>
    `text-sm font-medium ${isActive ? 'text-slate-900' : 'text-slate-500 hover:text-slate-800'}`;

  return (
    <nav className="flex items-center gap-6 border-b border-slate-200 bg-white px-6 py-4">
      <span className="text-sm font-semibold text-slate-900">Asset Inventory Portal</span>
      <NavLink to="/dashboard" className={linkClass}>Dashboard</NavLink>
      <NavLink to="/clients" className={linkClass}>Clients</NavLink>
      <span className="ml-auto text-sm text-slate-500">{currentUser?.email}</span>
      <button
        type="button"
        onClick={handleLogout}
        className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50"
      >
        Sign out
      </button>
    </nav>
  );
}

import { Navigate, Outlet } from 'react-router-dom';
import { useAuth } from './AuthContext';

// Nests inside ProtectedRoute (auth already confirmed) — this only adds the
// role check, so standard users bounce to the dashboard instead of /login.
export default function AdminRoute() {
  const { isAdmin, loading } = useAuth();

  if (loading) {
    return (
      <div className="flex min-h-screen items-center justify-center bg-slate-50 text-sm text-slate-500 dark:bg-slate-950 dark:text-slate-400">
        Loading…
      </div>
    );
  }

  if (!isAdmin) {
    return <Navigate to="/dashboard" replace />;
  }

  return <Outlet />;
}

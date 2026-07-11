import { Navigate, Route, Routes } from 'react-router-dom';
import { AuthProvider } from './auth/AuthContext';
import ProtectedRoute from './auth/ProtectedRoute';
import Login from './auth/Login';
import Navbar from './components/Navbar';
import Dashboard from './pages/Dashboard';
import ClientAssets from './pages/ClientAssets';
import EmployeeList from './pages/EmployeeList';
import TicketList from './pages/TicketList';
import TicketDetail from './pages/TicketDetail';

function AppLayout({ children }) {
  return (
    <div className="min-h-screen bg-slate-50 dark:bg-slate-950">
      <Navbar />
      {children}
    </div>
  );
}

export default function App() {
  return (
    <AuthProvider>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route element={<ProtectedRoute />}>
          <Route path="/dashboard" element={<AppLayout><Dashboard /></AppLayout>} />
          <Route path="/clients/:clientId" element={<AppLayout><ClientAssets /></AppLayout>} />
          <Route path="/clients/:clientId/employees" element={<AppLayout><EmployeeList /></AppLayout>} />
          <Route path="/tickets" element={<AppLayout><TicketList /></AppLayout>} />
          <Route path="/tickets/:ticketId" element={<AppLayout><TicketDetail /></AppLayout>} />
        </Route>
        <Route path="*" element={<Navigate to="/dashboard" replace />} />
      </Routes>
    </AuthProvider>
  );
}

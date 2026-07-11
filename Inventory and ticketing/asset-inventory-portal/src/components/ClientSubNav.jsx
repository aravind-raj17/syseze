import { useNavigate } from 'react-router-dom';

export default function ClientSubNav({ clientId, active }) {
  const navigate = useNavigate();

  const tabClass = (tab) =>
    `rounded-lg px-3 py-1.5 text-sm font-medium ${
      active === tab
        ? 'bg-blue-600 text-white'
        : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'
    }`;

  return (
    <div className="flex gap-1">
      <button type="button" onClick={() => navigate(`/clients/${clientId}`)} className={tabClass('assets')}>
        Assets
      </button>
      <button type="button" onClick={() => navigate(`/clients/${clientId}/employees`)} className={tabClass('employees')}>
        Employees
      </button>
    </div>
  );
}

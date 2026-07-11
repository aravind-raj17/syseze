import { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { useClients } from '../hooks/useClients';
import { useClientEmployees } from '../hooks/useClientEmployees';
import { createEmployee, updateEmployee } from '../lib/employees';
import { exportEmployeesCSV, exportEmployeesXLSX, exportEmployeesPDF } from '../lib/employeeExport';
import { useAuth } from '../auth/AuthContext';
import { EMPTY_EMPLOYEE_FORM } from '../employeeConstants';
import EmployeeStatusBadge from '../components/EmployeeStatusBadge';
import EmployeeFormDialog from '../components/EmployeeFormDialog';
import EmployeeBulkUploadDialog from '../components/EmployeeBulkUploadDialog';
import ClientSubNav from '../components/ClientSubNav';
import ExportMenu from '../components/ExportMenu';

export default function EmployeeList() {
  const { clientId } = useParams();
  const navigate = useNavigate();
  const { currentUser } = useAuth();
  const { clients } = useClients();
  const { employees, loading } = useClientEmployees(clientId);

  const [formOpen, setFormOpen] = useState(false);
  const [editingEmployee, setEditingEmployee] = useState(null);
  const [saving, setSaving] = useState(false);
  const [bulkOpen, setBulkOpen] = useState(false);
  const [importNotice, setImportNotice] = useState('');

  const client = clients.find((c) => c.id === clientId);
  const exportFilenameBase = client ? `${client.code}-employees` : 'employees';

  const openNew = () => {
    setEditingEmployee(null);
    setFormOpen(true);
  };
  const openEdit = (employee) => {
    setEditingEmployee(employee);
    setFormOpen(true);
  };

  const handleSave = async (values) => {
    setSaving(true);
    try {
      if (editingEmployee) {
        await updateEmployee(editingEmployee.id, clientId, editingEmployee, values, currentUser.email);
      } else {
        await createEmployee(clientId, client?.name || '', values, currentUser.email);
      }
      setFormOpen(false);
    } finally {
      setSaving(false);
    }
  };

  const handleImported = (count) => {
    setImportNotice(`Imported ${count} employee${count === 1 ? '' : 's'}.`);
    setTimeout(() => setImportNotice(''), 5000);
  };

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-4 p-6">
      <div className="flex items-start gap-3">
        <button
          type="button"
          onClick={() => navigate('/dashboard')}
          className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          ← Back
        </button>
        <div className="flex-1">
          <div className="flex items-center gap-2">
            <h1 className="text-xl font-semibold text-slate-900 dark:text-white">{client?.name || '…'}</h1>
            {client && (
              <span className="rounded-full border border-slate-300 px-2 py-0.5 text-xs font-medium text-slate-500 dark:border-slate-700 dark:text-slate-400">
                {client.code}
              </span>
            )}
          </div>
          <p className="text-sm text-slate-500 dark:text-slate-400">
            {client?.contactPerson} · {client?.contactEmail}
          </p>
          <div className="mt-2">
            <ClientSubNav clientId={clientId} active="employees" />
          </div>
        </div>
        <ExportMenu
          disabled={employees.length === 0}
          options={[
            { label: 'CSV', onSelect: () => exportEmployeesCSV(employees, exportFilenameBase) },
            { label: 'Excel (.xlsx)', onSelect: () => exportEmployeesXLSX(employees, exportFilenameBase) },
            { label: 'PDF', onSelect: () => exportEmployeesPDF(employees, exportFilenameBase, `${client?.name || ''} — Employees`) },
          ]}
        />
        <button
          type="button"
          onClick={() => setBulkOpen(true)}
          className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          Bulk upload
        </button>
        <button
          type="button"
          onClick={openNew}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          + Add employee
        </button>
      </div>

      {importNotice && (
        <p className="rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
          {importNotice}
        </p>
      )}

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading employees…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="px-4 py-3">Name</th>
                <th className="px-4 py-3">Email ID</th>
                <th className="px-4 py-3">Organization Name</th>
                <th className="px-4 py-3">License Assigned</th>
                <th className="px-4 py-3">Status</th>
                <th className="px-4 py-3" />
              </tr>
            </thead>
            <tbody>
              {employees.map((e) => (
                <tr key={e.id} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
                  <td className="px-4 py-3 font-medium text-slate-900 dark:text-white">{e.name}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{e.email}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{e.organizationName}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{e.licenseAssigned || '—'}</td>
                  <td className="px-4 py-3"><EmployeeStatusBadge status={e.status} /></td>
                  <td className="px-4 py-3">
                    <div className="flex justify-end">
                      <button
                        type="button"
                        onClick={() => openEdit(e)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        Edit
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && employees.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No employees added for this organization yet.</p>
      )}

      <EmployeeFormDialog
        open={formOpen}
        title={editingEmployee ? 'Edit employee' : 'Add employee'}
        organizationName={client?.name || ''}
        initialValues={editingEmployee ? { name: editingEmployee.name, email: editingEmployee.email, licenseAssigned: editingEmployee.licenseAssigned, status: editingEmployee.status } : EMPTY_EMPLOYEE_FORM}
        saving={saving}
        onSave={handleSave}
        onClose={() => setFormOpen(false)}
      />

      <EmployeeBulkUploadDialog
        open={bulkOpen}
        clientId={clientId}
        organizationName={client?.name || ''}
        changedBy={currentUser.email}
        onClose={() => setBulkOpen(false)}
        onImported={handleImported}
      />
    </div>
  );
}

import { useMemo } from 'react';
import { useAllAssets } from '../hooks/useAllAssets';
import { useAllEmployees } from '../hooks/useAllEmployees';
import { useAllDailyTasks } from '../hooks/useAllDailyTasks';
import { useTickets } from '../hooks/useTickets';
import { useClients } from '../hooks/useClients';
import {
  exportAllAssetsCSV,
  exportAllAssetsXLSX,
  exportAllAssetsPDF,
  exportAllTicketsCSV,
  exportAllTicketsXLSX,
  exportAllTicketsPDF,
  exportCombinedPDF,
} from '../lib/reports';
import { exportEmployeesCSV, exportEmployeesXLSX, exportEmployeesPDF } from '../lib/employeeExport';
import { assetStatusMatrix, employeeStatusMatrix, ticketOpenClosedCounts, dailyTaskCountsThisMonth } from '../lib/reportSummary';
import { STATUSES } from '../constants';
import { EMPLOYEE_STATUSES } from '../employeeConstants';
import ExportMenu from '../components/ExportMenu';
import StatTile from '../components/StatTile';
import HorizontalBarChart from '../components/HorizontalBarChart';
import { TicketIcon } from '../components/icons';

function ReportCard({ title, description, count, children }) {
  return (
    <div className="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
      <div>
        <h3 className="text-base font-semibold text-slate-900 dark:text-white">{title}</h3>
        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">{description}</p>
      </div>
      <p className="text-2xl font-semibold text-slate-900 dark:text-white">{count.toLocaleString()}</p>
      <div className="mt-auto">{children}</div>
    </div>
  );
}

function MatrixTable({ title, rows, columns }) {
  return (
    <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
      <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">{title}</h3>
      <table className="w-full text-left text-sm">
        <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
          <tr>
            <th className="py-2 pr-4">Client</th>
            {columns.map((c) => <th key={c} className="py-2 pr-4">{c}</th>)}
          </tr>
        </thead>
        <tbody>
          {rows.map((row) => (
            <tr key={row.client} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
              <td className="py-2 pr-4 font-medium text-slate-900 dark:text-white">{row.client}</td>
              {columns.map((c) => <td key={c} className="py-2 pr-4 text-slate-600 dark:text-slate-300">{row[c]}</td>)}
            </tr>
          ))}
          {rows.length === 0 && (
            <tr><td colSpan={columns.length + 1} className="py-3 text-slate-500 dark:text-slate-400">No clients yet.</td></tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default function Reports() {
  const { assets, loading: assetsLoading } = useAllAssets();
  const { employees, loading: employeesLoading } = useAllEmployees();
  const { tasks: dailyTasks, loading: dailyTasksLoading } = useAllDailyTasks();
  const { tickets, loading: ticketsLoading } = useTickets();
  const { clients, loading: clientsLoading } = useClients();

  const loading = assetsLoading || employeesLoading || ticketsLoading || clientsLoading || dailyTasksLoading;
  const today = new Date().toISOString().slice(0, 10);
  const monthLabel = new Date().toLocaleDateString(undefined, { month: 'long', year: 'numeric' });

  const assetMatrix = useMemo(() => assetStatusMatrix(assets, clients), [assets, clients]);
  const employeeMatrix = useMemo(() => employeeStatusMatrix(employees, clients), [employees, clients]);
  const ticketCounts = useMemo(() => ticketOpenClosedCounts(tickets), [tickets]);
  const taskCounts = useMemo(() => dailyTaskCountsThisMonth(dailyTasks), [dailyTasks]);

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-8 p-6">
      <div>
        <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Reports</h1>
        <p className="text-sm text-slate-500 dark:text-slate-400">Admin-only — summaries and downloadable data across every client.</p>
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading report data…</p>
      ) : (
        <>
          <div className="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <StatTile label="Open tickets" value={ticketCounts.open} icon={TicketIcon} color="red" />
            <StatTile label="Closed tickets" value={ticketCounts.closed} icon={TicketIcon} color="green" />
          </div>

          <div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <MatrixTable title="Assets by status, per client" rows={assetMatrix} columns={STATUSES} />
            <MatrixTable title="Employees by status, per client" rows={employeeMatrix} columns={EMPLOYEE_STATUSES} />
          </div>

          <HorizontalBarChart title={`Daily task entries by staff — ${monthLabel}`} rows={taskCounts} />

          <div>
            <h2 className="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Downloads</h2>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
              <ReportCard title="Asset Inventory" description="Every asset across every client, with the owning client on each row." count={assets.length}>
                <ExportMenu
                  disabled={assets.length === 0}
                  options={[
                    { label: 'CSV', onSelect: () => exportAllAssetsCSV(assets, clients, `syseze-assets-${today}`) },
                    { label: 'Excel (.xlsx)', onSelect: () => exportAllAssetsXLSX(assets, clients, `syseze-assets-${today}`) },
                    { label: 'PDF', onSelect: () => exportAllAssetsPDF(assets, clients, `syseze-assets-${today}`) },
                  ]}
                />
              </ReportCard>

              <ReportCard title="Tickets" description="Every ticket across every client, with status, priority, and assignee." count={tickets.length}>
                <ExportMenu
                  disabled={tickets.length === 0}
                  options={[
                    { label: 'CSV', onSelect: () => exportAllTicketsCSV(tickets, clients, `syseze-tickets-${today}`) },
                    { label: 'Excel (.xlsx)', onSelect: () => exportAllTicketsXLSX(tickets, clients, `syseze-tickets-${today}`) },
                    { label: 'PDF', onSelect: () => exportAllTicketsPDF(tickets, clients, `syseze-tickets-${today}`) },
                  ]}
                />
              </ReportCard>

              <ReportCard title="Employee Directory" description="Every employee across every client, with license and status." count={employees.length}>
                <ExportMenu
                  disabled={employees.length === 0}
                  options={[
                    { label: 'CSV', onSelect: () => exportEmployeesCSV(employees, `syseze-employees-${today}`) },
                    { label: 'Excel (.xlsx)', onSelect: () => exportEmployeesXLSX(employees, `syseze-employees-${today}`) },
                    { label: 'PDF', onSelect: () => exportEmployeesPDF(employees, `syseze-employees-${today}`, 'Employee Directory — All Clients') },
                  ]}
                />
              </ReportCard>

              <ReportCard title="Portfolio Summary" description="One branded PDF: summary stats plus full asset and ticket appendices." count={clients.length}>
                <ExportMenu
                  label="Download ▾"
                  options={[
                    { label: 'PDF', onSelect: () => exportCombinedPDF(assets, tickets, employees, clients, `syseze-portfolio-summary-${today}`) },
                  ]}
                />
              </ReportCard>
            </div>
          </div>
        </>
      )}
    </div>
  );
}

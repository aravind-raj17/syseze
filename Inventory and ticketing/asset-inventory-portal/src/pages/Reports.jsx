import { useAllAssets } from '../hooks/useAllAssets';
import { useAllEmployees } from '../hooks/useAllEmployees';
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
import ExportMenu from '../components/ExportMenu';

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

export default function Reports() {
  const { assets, loading: assetsLoading } = useAllAssets();
  const { employees, loading: employeesLoading } = useAllEmployees();
  const { tickets, loading: ticketsLoading } = useTickets();
  const { clients, loading: clientsLoading } = useClients();

  const loading = assetsLoading || employeesLoading || ticketsLoading || clientsLoading;
  const today = new Date().toISOString().slice(0, 10);

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-6 p-6">
      <div>
        <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Reports</h1>
        <p className="text-sm text-slate-500 dark:text-slate-400">Download data across every client as CSV, Excel, or a branded PDF.</p>
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading report data…</p>
      ) : (
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
      )}
    </div>
  );
}

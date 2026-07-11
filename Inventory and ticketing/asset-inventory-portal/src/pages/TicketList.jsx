import { useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useTickets } from '../hooks/useTickets';
import { useClients } from '../hooks/useClients';
import { useAuth } from '../auth/AuthContext';
import { TICKET_STATUSES, PRIORITY_LEVELS } from '../ticketConstants';
import TicketStatusBadge from '../components/TicketStatusBadge';
import TicketPriorityBadge from '../components/TicketPriorityBadge';
import NewTicketDialog from '../components/NewTicketDialog';

export default function TicketList() {
  const navigate = useNavigate();
  const { currentUser } = useAuth();
  const { tickets, loading } = useTickets();
  const { clients } = useClients();

  const [search, setSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('All');
  const [priorityFilter, setPriorityFilter] = useState('All');
  const [clientFilter, setClientFilter] = useState('All');
  const [formOpen, setFormOpen] = useState(false);

  const clientName = (id) => clients.find((c) => c.id === id)?.name || '—';

  const filtered = useMemo(() => {
    const q = search.trim().toLowerCase();
    return tickets.filter((t) => {
      if (q && !t.title.toLowerCase().includes(q) && !clientName(t.clientId).toLowerCase().includes(q)) return false;
      if (statusFilter !== 'All' && t.status !== statusFilter) return false;
      if (priorityFilter !== 'All' && t.priority !== priorityFilter) return false;
      if (clientFilter !== 'All' && t.clientId !== clientFilter) return false;
      return true;
    });
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [tickets, clients, search, statusFilter, priorityFilter, clientFilter]);

  const formatDate = (ts) => (ts?.toDate ? ts.toDate().toLocaleDateString() : '—');

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-4 p-6">
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Tickets</h1>
          <p className="text-sm text-slate-500 dark:text-slate-400">Track and resolve requests across all clients.</p>
        </div>
        <button
          type="button"
          onClick={() => setFormOpen(true)}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          + New ticket
        </button>
      </div>

      <div className="flex flex-wrap gap-3">
        <input
          type="search"
          placeholder="Search title or client…"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          className="input min-w-[220px] flex-1"
        />
        <select className="input w-auto min-w-[150px]" value={clientFilter} onChange={(e) => setClientFilter(e.target.value)}>
          <option value="All">All clients</option>
          {clients.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
        </select>
        <select className="input w-auto min-w-[150px]" value={statusFilter} onChange={(e) => setStatusFilter(e.target.value)}>
          <option value="All">All statuses</option>
          {TICKET_STATUSES.map((s) => <option key={s} value={s}>{s}</option>)}
        </select>
        <select className="input w-auto min-w-[150px]" value={priorityFilter} onChange={(e) => setPriorityFilter(e.target.value)}>
          <option value="All">All priorities</option>
          {PRIORITY_LEVELS.map((p) => <option key={p} value={p}>{p}</option>)}
        </select>
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading tickets…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="px-4 py-3">Title</th>
                <th className="px-4 py-3">Client</th>
                <th className="px-4 py-3">Status</th>
                <th className="px-4 py-3">Priority</th>
                <th className="px-4 py-3">Category</th>
                <th className="px-4 py-3">Assigned To</th>
                <th className="px-4 py-3">Opened</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((t) => (
                <tr
                  key={t.id}
                  onClick={() => navigate(`/tickets/${t.id}`)}
                  className="cursor-pointer border-b border-slate-100 last:border-0 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/60"
                >
                  <td className="px-4 py-3 font-medium text-slate-900 dark:text-white">{t.title}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{clientName(t.clientId)}</td>
                  <td className="px-4 py-3"><TicketStatusBadge status={t.status} /></td>
                  <td className="px-4 py-3"><TicketPriorityBadge priority={t.priority} /></td>
                  <td className="px-4 py-3 dark:text-slate-200">{t.category}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{t.assignedTo || '—'}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{formatDate(t.createdAt)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && filtered.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No tickets match the current search and filters.</p>
      )}

      <NewTicketDialog
        open={formOpen}
        createdBy={currentUser.email}
        onClose={() => setFormOpen(false)}
        onCreated={(ticketId) => {
          setFormOpen(false);
          navigate(`/tickets/${ticketId}`);
        }}
      />
    </div>
  );
}

import { useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useTickets } from '../hooks/useTickets';
import { useClients } from '../hooks/useClients';
import { useAuth } from '../auth/AuthContext';
import { bulkUpdateTickets } from '../lib/tickets';
import { TICKET_STATUSES, PRIORITY_LEVELS } from '../ticketConstants';
import TicketStatusBadge from '../components/TicketStatusBadge';
import TicketPriorityBadge from '../components/TicketPriorityBadge';
import NewTicketDialog from '../components/NewTicketDialog';

const SAVED_FILTERS_KEY = 'asset-portal-ticket-filters';

function isOverdue(ticket) {
  if (!ticket.dueDate || ['Solved', 'Closed'].includes(ticket.status)) return false;
  return ticket.dueDate < new Date().toISOString().slice(0, 10);
}

function loadSavedFilters() {
  try {
    return JSON.parse(localStorage.getItem(SAVED_FILTERS_KEY) || '[]');
  } catch {
    return [];
  }
}

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
  const [selected, setSelected] = useState(new Set());
  const [bulkAssignee, setBulkAssignee] = useState('');
  const [savedFilters, setSavedFilters] = useState(loadSavedFilters);

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

  // Selection can go stale as tickets update/filter changes — drop any ids
  // that are no longer in the visible set.
  useEffect(() => {
    setSelected((prev) => {
      const visible = new Set(filtered.map((t) => t.id));
      const next = new Set([...prev].filter((id) => visible.has(id)));
      return next.size === prev.size ? prev : next;
    });
  }, [filtered]);

  const formatDate = (ts) => (ts?.toDate ? ts.toDate().toLocaleDateString() : '—');

  const toggleSelected = (id) => {
    setSelected((prev) => {
      const next = new Set(prev);
      if (next.has(id)) next.delete(id); else next.add(id);
      return next;
    });
  };

  const toggleSelectAll = () => {
    setSelected((prev) => (prev.size === filtered.length ? new Set() : new Set(filtered.map((t) => t.id))));
  };

  const handleBulkStatus = async (status) => {
    if (!status || selected.size === 0) return;
    await bulkUpdateTickets([...selected], { status }, currentUser.email);
    setSelected(new Set());
  };

  const handleBulkAssign = async () => {
    if (!bulkAssignee.trim() || selected.size === 0) return;
    await bulkUpdateTickets([...selected], { assignedTo: bulkAssignee.trim() }, currentUser.email);
    setBulkAssignee('');
    setSelected(new Set());
  };

  const saveCurrentFilter = () => {
    const name = window.prompt('Name this filter preset:');
    if (!name?.trim()) return;
    const next = [...savedFilters.filter((f) => f.name !== name), { name: name.trim(), search, statusFilter, priorityFilter, clientFilter }];
    setSavedFilters(next);
    localStorage.setItem(SAVED_FILTERS_KEY, JSON.stringify(next));
  };

  const applyFilter = (name) => {
    const preset = savedFilters.find((f) => f.name === name);
    if (!preset) return;
    setSearch(preset.search);
    setStatusFilter(preset.statusFilter);
    setPriorityFilter(preset.priorityFilter);
    setClientFilter(preset.clientFilter);
  };

  const deleteFilter = (name) => {
    const next = savedFilters.filter((f) => f.name !== name);
    setSavedFilters(next);
    localStorage.setItem(SAVED_FILTERS_KEY, JSON.stringify(next));
  };

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
        <button
          type="button"
          onClick={saveCurrentFilter}
          className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          Save filter
        </button>
      </div>

      {savedFilters.length > 0 && (
        <div className="flex flex-wrap items-center gap-2">
          <span className="text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">Saved:</span>
          {savedFilters.map((f) => (
            <span key={f.name} className="flex items-center gap-1 rounded-full border border-slate-300 pl-3 pr-1 py-0.5 text-xs dark:border-slate-700">
              <button type="button" onClick={() => applyFilter(f.name)} className="font-medium text-slate-700 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400">
                {f.name}
              </button>
              <button type="button" onClick={() => deleteFilter(f.name)} aria-label={`Remove ${f.name}`} className="rounded-full px-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800">
                ✕
              </button>
            </span>
          ))}
        </div>
      )}

      {selected.size > 0 && (
        <div className="flex flex-wrap items-center gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2.5 dark:border-blue-500/30 dark:bg-blue-500/10">
          <span className="text-sm font-medium text-blue-700 dark:text-blue-400">{selected.size} selected</span>
          <select
            className="input w-auto min-w-[160px]"
            defaultValue=""
            onChange={(e) => { handleBulkStatus(e.target.value); e.target.value = ''; }}
          >
            <option value="" disabled>Change status to…</option>
            {TICKET_STATUSES.map((s) => <option key={s} value={s}>{s}</option>)}
          </select>
          <div className="flex items-center gap-1">
            <input
              className="input w-auto min-w-[180px]"
              placeholder="Assign to (email)"
              value={bulkAssignee}
              onChange={(e) => setBulkAssignee(e.target.value)}
            />
            <button
              type="button"
              onClick={handleBulkAssign}
              className="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-white dark:border-slate-700 dark:text-slate-300"
            >
              Assign
            </button>
          </div>
          <button
            type="button"
            onClick={() => setSelected(new Set())}
            className="ml-auto text-sm font-medium text-blue-700 hover:underline dark:text-blue-400"
          >
            Clear selection
          </button>
        </div>
      )}

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading tickets…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                <th className="w-10 px-4 py-3">
                  <input
                    type="checkbox"
                    checked={filtered.length > 0 && selected.size === filtered.length}
                    onChange={toggleSelectAll}
                    aria-label="Select all tickets"
                  />
                </th>
                <th className="px-4 py-3">Title</th>
                <th className="px-4 py-3">Client</th>
                <th className="px-4 py-3">Status</th>
                <th className="px-4 py-3">Priority</th>
                <th className="px-4 py-3">Category</th>
                <th className="px-4 py-3">Assigned To</th>
                <th className="px-4 py-3">Due</th>
                <th className="px-4 py-3">Opened</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((t) => {
                const overdue = isOverdue(t);
                return (
                  <tr
                    key={t.id}
                    onClick={() => navigate(`/tickets/${t.id}`)}
                    className="cursor-pointer border-b border-slate-100 last:border-0 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/60"
                  >
                    <td className="px-4 py-3" onClick={(e) => e.stopPropagation()}>
                      <input type="checkbox" checked={selected.has(t.id)} onChange={() => toggleSelected(t.id)} aria-label={`Select ${t.title}`} />
                    </td>
                    <td className="px-4 py-3 font-medium text-slate-900 dark:text-white">{t.title}</td>
                    <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{clientName(t.clientId)}</td>
                    <td className="px-4 py-3"><TicketStatusBadge status={t.status} /></td>
                    <td className="px-4 py-3"><TicketPriorityBadge priority={t.priority} /></td>
                    <td className="px-4 py-3 dark:text-slate-200">{t.category}</td>
                    <td className="px-4 py-3 dark:text-slate-200">{t.assignedTo || '—'}</td>
                    <td className="px-4 py-3">
                      {t.dueDate ? (
                        <span className={overdue ? 'font-medium text-red-600 dark:text-red-400' : 'text-slate-500 dark:text-slate-400'}>
                          {t.dueDate}{overdue ? ' (overdue)' : ''}
                        </span>
                      ) : (
                        <span className="text-slate-400 dark:text-slate-500">—</span>
                      )}
                    </td>
                    <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{formatDate(t.createdAt)}</td>
                  </tr>
                );
              })}
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

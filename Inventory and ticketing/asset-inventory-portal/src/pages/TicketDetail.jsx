import { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { useTicket } from '../hooks/useTicket';
import { useTicketComments } from '../hooks/useTicketComments';
import { useClients } from '../hooks/useClients';
import { useClientAssets } from '../hooks/useClientAssets';
import { useAuth } from '../auth/AuthContext';
import { addComment, updateComment, deleteComment, updateTicketFields, updateTicketStatus } from '../lib/tickets';
import {
  TICKET_STATUSES,
  TICKET_CATEGORIES,
  REQUEST_SOURCES,
  URGENCY_LEVELS,
  IMPACT_LEVELS,
  computePriority,
} from '../ticketConstants';
import TicketStatusBadge from '../components/TicketStatusBadge';
import TicketPriorityBadge from '../components/TicketPriorityBadge';
import TicketTimelineItem from '../components/TicketTimelineItem';

function isOverdue(ticket) {
  if (!ticket.dueDate || ['Solved', 'Closed'].includes(ticket.status)) return false;
  return ticket.dueDate < new Date().toISOString().slice(0, 10);
}

export default function TicketDetail() {
  const { ticketId } = useParams();
  const navigate = useNavigate();
  const { currentUser, isAdmin } = useAuth();
  const { ticket, loading } = useTicket(ticketId);
  const { comments } = useTicketComments(ticketId);
  const { clients } = useClients();
  const { assets } = useClientAssets(ticket?.clientId);

  const [reply, setReply] = useState('');
  const [sending, setSending] = useState(false);
  const [tab, setTab] = useState('comments');

  if (loading) {
    return <p className="p-6 text-sm text-slate-500 dark:text-slate-400">Loading ticket…</p>;
  }
  if (!ticket) {
    return <p className="p-6 text-sm text-slate-500 dark:text-slate-400">Ticket not found.</p>;
  }

  const client = clients.find((c) => c.id === ticket.clientId);
  const asset = assets.find((a) => a.id === ticket.assetId);
  const overdue = isOverdue(ticket);

  const patchField = (field) => async (e) => {
    await updateTicketFields(ticketId, { [field]: e.target.value }, currentUser.email);
  };

  const handleStatusChange = async (e) => {
    await updateTicketStatus(ticketId, e.target.value, currentUser.email);
  };

  const handleUrgencyChange = async (e) => {
    const urgency = e.target.value;
    const priority = computePriority(urgency, ticket.impact);
    await updateTicketFields(ticketId, { urgency, priority }, currentUser.email);
  };

  const handleImpactChange = async (e) => {
    const impact = e.target.value;
    const priority = computePriority(ticket.urgency, impact);
    await updateTicketFields(ticketId, { impact, priority }, currentUser.email);
  };

  const handleAssignedToBlur = async (e) => {
    if (e.target.value === ticket.assignedTo) return;
    await updateTicketFields(ticketId, { assignedTo: e.target.value }, currentUser.email);
  };

  const handleLocationBlur = async (e) => {
    if (e.target.value === ticket.location) return;
    await updateTicketFields(ticketId, { location: e.target.value }, currentUser.email);
  };

  const handleDueDateBlur = async (e) => {
    const value = e.target.value || null;
    if (value === ticket.dueDate) return;
    await updateTicketFields(ticketId, { dueDate: value }, currentUser.email);
  };

  const handleObserversBlur = async (e) => {
    const observers = e.target.value.split(',').map((s) => s.trim()).filter(Boolean);
    const current = (ticket.observers || []).join(', ');
    if (e.target.value === current) return;
    await updateTicketFields(ticketId, { observers }, currentUser.email);
  };

  const handleSendReply = async () => {
    if (!reply.trim()) return;
    setSending(true);
    try {
      await addComment(ticketId, {
        type: 'followup',
        content: reply.trim(),
        authorEmail: currentUser.email,
      });
      setReply('');
    } finally {
      setSending(false);
    }
  };

  const followups = comments.filter((c) => c.type !== 'system');
  const history = comments.filter((c) => c.type === 'system');

  return (
    <div className="mx-auto flex max-w-[1300px] flex-col gap-4 p-6">
      <div className="flex items-start gap-3">
        <button
          type="button"
          onClick={() => navigate('/tickets')}
          className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          ← Back
        </button>
        <div className="flex-1">
          <div className="flex flex-wrap items-center gap-2">
            <h1 className="text-xl font-semibold text-slate-900 dark:text-white">{ticket.title}</h1>
            <TicketStatusBadge status={ticket.status} />
            <TicketPriorityBadge priority={ticket.priority} />
            {overdue && (
              <span className="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-400">
                Overdue
              </span>
            )}
          </div>
          <p className="text-sm text-slate-500 dark:text-slate-400">{client?.name} · {ticket.category}</p>
        </div>
      </div>

      <div className="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_320px]">
        <div className="flex flex-col gap-3">
          <div className="flex gap-1 border-b border-slate-200 dark:border-slate-800">
            <button
              type="button"
              onClick={() => setTab('comments')}
              className={`px-3 py-2 text-sm font-medium ${tab === 'comments' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100'}`}
            >
              Comments
            </button>
            <button
              type="button"
              onClick={() => setTab('history')}
              className={`px-3 py-2 text-sm font-medium ${tab === 'history' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100'}`}
            >
              History ({history.length})
            </button>
          </div>

          {tab === 'comments' ? (
            <>
              <TicketTimelineItem type="description" author={ticket.requester} createdAt={ticket.createdAt} content={ticket.description} />
              {followups.map((c) => (
                <TicketTimelineItem
                  key={c.id}
                  type="followup"
                  author={c.authorEmail}
                  createdAt={c.createdAt}
                  editedAt={c.editedAt}
                  content={c.content}
                  canEdit={c.authorEmail === currentUser.email}
                  canDelete={c.authorEmail === currentUser.email || isAdmin}
                  onEdit={(newContent) => updateComment(c.id, newContent)}
                  onDelete={() => deleteComment(c.id)}
                />
              ))}

              <div className="mt-2 flex flex-col gap-2 rounded-lg border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <textarea
                  rows={3}
                  className="input"
                  placeholder="Write a reply…"
                  value={reply}
                  onChange={(e) => setReply(e.target.value)}
                />
                <button
                  type="button"
                  onClick={handleSendReply}
                  disabled={sending}
                  className="self-end rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-60"
                >
                  {sending ? 'Sending…' : 'Answer'}
                </button>
              </div>
            </>
          ) : (
            <div className="flex flex-col gap-2">
              {history.length === 0 && <p className="text-sm text-slate-500 dark:text-slate-400">No changes recorded yet.</p>}
              {history.map((c) => (
                <div key={c.id} className="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
                  {c.content}
                  {c.createdAt?.toDate && <span className="ml-2 text-slate-400 dark:text-slate-500">· {c.createdAt.toDate().toLocaleString()}</span>}
                </div>
              ))}
            </div>
          )}
        </div>

        <div className="flex flex-col gap-4">
          <div className="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">Ticket</h3>
            <div className="flex flex-col items-stretch gap-3">
              <div className="grid grid-cols-2 gap-3">
                <SidebarField label="Client">
                  <p className="truncate text-sm text-slate-700 dark:text-slate-200">{client?.name || '—'}</p>
                </SidebarField>
                <SidebarField label="Related asset">
                  <p className="truncate text-sm text-slate-700 dark:text-slate-200">{asset ? asset.assetTag : '—'}</p>
                </SidebarField>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <SidebarField label="Type">
                  <p className="text-sm text-slate-700 dark:text-slate-200">{ticket.type}</p>
                </SidebarField>
                <SidebarField label="Category">
                  <select className="input" defaultValue={ticket.category} onChange={patchField('category')}>
                    {TICKET_CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
                  </select>
                </SidebarField>
              </div>

              <hr className="border-slate-100 dark:border-slate-800" />

              <SidebarField label="Status">
                <select className="input" value={ticket.status} onChange={handleStatusChange}>
                  {TICKET_STATUSES.map((s) => <option key={s} value={s}>{s}</option>)}
                </select>
              </SidebarField>

              <div className="grid grid-cols-2 gap-3">
                <SidebarField label="Urgency">
                  <select className="input" value={ticket.urgency} onChange={handleUrgencyChange}>
                    {URGENCY_LEVELS.map((u) => <option key={u} value={u}>{u}</option>)}
                  </select>
                </SidebarField>
                <SidebarField label="Impact">
                  <select className="input" value={ticket.impact} onChange={handleImpactChange}>
                    {IMPACT_LEVELS.map((i) => <option key={i} value={i}>{i}</option>)}
                  </select>
                </SidebarField>
              </div>

              <div className="flex items-center justify-between">
                <span className="text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">Priority</span>
                <TicketPriorityBadge priority={ticket.priority} />
              </div>

              <hr className="border-slate-100 dark:border-slate-800" />

              <div className="grid grid-cols-2 gap-3">
                <SidebarField label="Location">
                  <input className="input" defaultValue={ticket.location} onBlur={handleLocationBlur} />
                </SidebarField>
                <SidebarField label="Due date">
                  <input type="date" className="input" defaultValue={ticket.dueDate || ''} onBlur={handleDueDateBlur} />
                </SidebarField>
              </div>

              <SidebarField label="Request source">
                <select className="input" defaultValue={ticket.source} onChange={patchField('source')}>
                  {REQUEST_SOURCES.map((s) => <option key={s} value={s}>{s}</option>)}
                </select>
              </SidebarField>
            </div>
          </div>

          <div className="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">Actors</h3>
            <div className="flex flex-col gap-3">
              <SidebarField label="Requester">
                <p className="text-sm text-slate-700 dark:text-slate-200">{ticket.requester}</p>
              </SidebarField>
              <SidebarField label="Watchers">
                <input
                  className="input"
                  placeholder="Comma-separated emails"
                  defaultValue={(ticket.observers || []).join(', ')}
                  onBlur={handleObserversBlur}
                />
              </SidebarField>
              <SidebarField label="Assigned to">
                <input className="input" placeholder="Staff email" defaultValue={ticket.assignedTo} onBlur={handleAssignedToBlur} />
              </SidebarField>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

function SidebarField({ label, children }) {
  return (
    <div className="flex flex-col gap-1">
      <span className="text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">{label}</span>
      {children}
    </div>
  );
}

import { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { useTicket } from '../hooks/useTicket';
import { useTicketComments } from '../hooks/useTicketComments';
import { useClients } from '../hooks/useClients';
import { useClientAssets } from '../hooks/useClientAssets';
import { useAuth } from '../auth/AuthContext';
import { addComment, updateTicketFields, updateTicketStatus } from '../lib/tickets';
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

export default function TicketDetail() {
  const { ticketId } = useParams();
  const navigate = useNavigate();
  const { currentUser } = useAuth();
  const { ticket, loading } = useTicket(ticketId);
  const { comments } = useTicketComments(ticketId);
  const { clients } = useClients();
  const { assets } = useClientAssets(ticket?.clientId);

  const [reply, setReply] = useState('');
  const [sending, setSending] = useState(false);

  if (loading) {
    return <p className="p-6 text-sm text-slate-500 dark:text-slate-400">Loading ticket…</p>;
  }
  if (!ticket) {
    return <p className="p-6 text-sm text-slate-500 dark:text-slate-400">Ticket not found.</p>;
  }

  const client = clients.find((c) => c.id === ticket.clientId);
  const asset = assets.find((a) => a.id === ticket.assetId);

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
          <div className="flex items-center gap-2">
            <h1 className="text-xl font-semibold text-slate-900 dark:text-white">{ticket.title}</h1>
            <TicketStatusBadge status={ticket.status} />
            <TicketPriorityBadge priority={ticket.priority} />
          </div>
          <p className="text-sm text-slate-500 dark:text-slate-400">{client?.name} · {ticket.category}</p>
        </div>
      </div>

      <div className="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_320px]">
        <div className="flex flex-col gap-3">
          <TicketTimelineItem type="description" author={ticket.requester} createdAt={ticket.createdAt} content={ticket.description} />
          {comments.map((c) =>
            c.type === 'system' ? (
              <p key={c.id} className="px-1 text-xs italic text-slate-400 dark:text-slate-500">
                {c.content}
              </p>
            ) : (
              <TicketTimelineItem
                key={c.id}
                type="followup"
                author={c.authorEmail}
                createdAt={c.createdAt}
                content={c.content}
              />
            )
          )}

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
        </div>

        <div className="flex flex-col gap-4">
          <div className="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">Ticket</h3>
            <div className="flex flex-col gap-3">
              <SidebarField label="Client">
                <p className="text-sm text-slate-700 dark:text-slate-200">{client?.name || '—'}</p>
              </SidebarField>
              <SidebarField label="Related asset">
                <p className="text-sm text-slate-700 dark:text-slate-200">{asset ? `${asset.assetTag} — ${[asset.brand, asset.model].filter(Boolean).join(' ')}` : '—'}</p>
              </SidebarField>
              <SidebarField label="Type">
                <p className="text-sm text-slate-700 dark:text-slate-200">{ticket.type}</p>
              </SidebarField>
              <SidebarField label="Category">
                <select className="input" defaultValue={ticket.category} onChange={patchField('category')}>
                  {TICKET_CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
                </select>
              </SidebarField>
              <SidebarField label="Status">
                <select className="input" value={ticket.status} onChange={handleStatusChange}>
                  {TICKET_STATUSES.map((s) => <option key={s} value={s}>{s}</option>)}
                </select>
              </SidebarField>
              <SidebarField label="Request source">
                <select className="input" defaultValue={ticket.source} onChange={patchField('source')}>
                  {REQUEST_SOURCES.map((s) => <option key={s} value={s}>{s}</option>)}
                </select>
              </SidebarField>
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
              <SidebarField label="Priority">
                <TicketPriorityBadge priority={ticket.priority} />
              </SidebarField>
              <SidebarField label="Location">
                <input className="input" defaultValue={ticket.location} onBlur={handleLocationBlur} />
              </SidebarField>
            </div>
          </div>

          <div className="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <h3 className="mb-3 text-sm font-semibold text-slate-900 dark:text-white">Actors</h3>
            <div className="flex flex-col gap-3">
              <SidebarField label="Requester">
                <p className="text-sm text-slate-700 dark:text-slate-200">{ticket.requester}</p>
              </SidebarField>
              <SidebarField label="Observers">
                <p className="text-sm text-slate-700 dark:text-slate-200">
                  {ticket.observers?.length > 0 ? ticket.observers.join(', ') : '—'}
                </p>
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

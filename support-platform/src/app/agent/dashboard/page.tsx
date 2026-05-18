'use client';
import { useState, useEffect, useCallback } from 'react';
import { useSession, signOut } from 'next-auth/react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { Ticket } from '@/types';

const STATUS_COLORS: Record<string, string> = {
  queued: 'bg-blue-100 text-blue-700',
  assigned: 'bg-orange-100 text-orange-700',
  in_session: 'bg-green-100 text-green-700',
  awaiting_confirmation: 'bg-purple-100 text-purple-700',
};

function timeAgo(date: string) {
  const secs = Math.floor((Date.now() - new Date(date).getTime()) / 1000);
  if (secs < 60) return `${secs}s ago`;
  if (secs < 3600) return `${Math.floor(secs / 60)}m ago`;
  return `${Math.floor(secs / 3600)}h ago`;
}

export default function AgentDashboardPage() {
  const { data: session, status } = useSession();
  const router = useRouter();
  const [tickets, setTickets] = useState<Ticket[]>([]);
  const [loading, setLoading] = useState(true);
  const [accepting, setAccepting] = useState<string | null>(null);

  useEffect(() => {
    if (status === 'unauthenticated') router.push('/agent/login');
  }, [status, router]);

  const loadTickets = useCallback(async () => {
    const res = await fetch('/api/tickets');
    if (res.ok) setTickets(await res.json());
    setLoading(false);
  }, []);

  useEffect(() => {
    loadTickets();
    const interval = setInterval(loadTickets, 10000);
    return () => clearInterval(interval);
  }, [loadTickets]);

  async function acceptTicket(ticketId: string) {
    setAccepting(ticketId);
    const agentId = (session?.user as { id?: string })?.id;
    await fetch(`/api/tickets/${ticketId}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ status: 'assigned', agentId }),
    });
    router.push(`/agent/session/${ticketId}`);
  }

  const pending = tickets.filter(t => t.status === 'queued');
  const active = tickets.filter(t => ['assigned', 'in_session', 'awaiting_confirmation'].includes(t.status) && t.agentId === (session?.user as { id?: string })?.id);
  const resolvedCount = 0; // TODO: fetch from a separate resolved endpoint

  if (status === 'loading' || loading) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="w-8 h-8 border-2 border-[#D97757] border-t-transparent rounded-full animate-spin" />
    </div>
  );

  return (
    <div className="min-h-screen bg-slate-50">
      <nav className="bg-white border-b border-slate-100 px-6 py-4">
        <div className="max-w-7xl mx-auto flex items-center justify-between">
          <div className="flex items-center gap-2">
            <div className="w-7 h-7 rounded-lg bg-[#D97757]" />
            <span className="font-semibold text-slate-900">TechSupport Pro</span>
            <span className="ml-2 px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded">Agent portal</span>
          </div>
          <div className="flex items-center gap-4">
            <span className="text-sm text-slate-600">{session?.user?.name}</span>
            <button onClick={() => signOut()} className="text-sm text-slate-500 hover:text-slate-700">Sign out</button>
          </div>
        </div>
      </nav>

      <div className="max-w-7xl mx-auto px-6 py-8">
        {/* Stats */}
        <div className="grid grid-cols-3 gap-4 mb-8">
          <div className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div className="text-2xl font-bold text-slate-900">{pending.length}</div>
            <div className="text-sm text-slate-500 mt-0.5">Tickets in queue</div>
          </div>
          <div className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div className="text-2xl font-bold text-[#D97757]">{active.length}</div>
            <div className="text-sm text-slate-500 mt-0.5">My active sessions</div>
          </div>
          <div className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div className="text-2xl font-bold text-green-600">{resolvedCount}</div>
            <div className="text-sm text-slate-500 mt-0.5">Resolved today</div>
          </div>
        </div>

        {/* Active sessions */}
        {active.length > 0 && (
          <div className="mb-8">
            <h2 className="text-base font-semibold text-slate-900 mb-3">My active sessions</h2>
            <div className="space-y-3">
              {active.map(ticket => (
                <div key={ticket.id} className="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center justify-between">
                  <div>
                    <div className="flex items-center gap-2 mb-1">
                      <span className="font-mono text-sm text-slate-700">{ticket.ticketNumber}</span>
                      <span className={`px-2 py-0.5 text-xs font-medium rounded ${STATUS_COLORS[ticket.status] || 'bg-slate-100 text-slate-600'}`}>
                        {ticket.status.replace(/_/g, ' ')}
                      </span>
                    </div>
                    <p className="text-sm text-slate-600">{ticket.customerName} · {ticket.issueCategory}</p>
                  </div>
                  <Link
                    href={`/agent/session/${ticket.id}`}
                    className="px-4 py-2 bg-[#D97757] text-white text-sm font-medium rounded-lg hover:bg-[#c4673e] transition-colors"
                  >
                    Rejoin session
                  </Link>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Ticket queue */}
        <div>
          <div className="flex items-center justify-between mb-3">
            <h2 className="text-base font-semibold text-slate-900">Ticket queue</h2>
            <button onClick={loadTickets} className="text-sm text-[#D97757] hover:text-[#c4673e]">Refresh</button>
          </div>

          {pending.length === 0 ? (
            <div className="bg-white rounded-xl p-12 shadow-sm border border-slate-100 text-center">
              <div className="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg className="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
              <p className="text-slate-600 font-medium">No tickets in queue</p>
              <p className="text-slate-400 text-sm mt-1">Check back soon or refresh.</p>
            </div>
          ) : (
            <div className="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-slate-100 bg-slate-50">
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ticket</th>
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Issue</th>
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Hours</th>
                    <th className="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Waiting</th>
                    <th className="px-4 py-3"></th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-50">
                  {pending.map(ticket => (
                    <tr key={ticket.id} className="hover:bg-slate-50 transition-colors">
                      <td className="px-4 py-3 font-mono text-sm text-slate-700">{ticket.ticketNumber}</td>
                      <td className="px-4 py-3">
                        <div className="text-sm font-medium text-slate-900">{ticket.customerName}</div>
                        <div className="text-xs text-slate-500">{ticket.customerEmail}</div>
                      </td>
                      <td className="px-4 py-3">
                        <span className="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs rounded">{ticket.issueCategory}</span>
                      </td>
                      <td className="px-4 py-3 text-sm text-slate-600 max-w-xs truncate">{ticket.issueDescription}</td>
                      <td className="px-4 py-3 text-sm text-slate-700">{ticket.hoursPurchased}h</td>
                      <td className="px-4 py-3 text-sm text-slate-500">{timeAgo(ticket.createdAt)}</td>
                      <td className="px-4 py-3">
                        <button
                          onClick={() => acceptTicket(ticket.id)}
                          disabled={accepting === ticket.id}
                          className="px-4 py-1.5 bg-[#D97757] text-white text-xs font-semibold rounded-lg hover:bg-[#c4673e] transition-colors disabled:opacity-50"
                        >
                          {accepting === ticket.id ? 'Accepting...' : 'Accept'}
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

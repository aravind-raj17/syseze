'use client';
import { useState, useEffect, useRef, useCallback } from 'react';
import { useSession } from 'next-auth/react';
import { useParams, useRouter } from 'next/navigation';
import Link from 'next/link';
import { Ticket, Message, TicketStatus } from '@/types';
import { getSocket, disconnectSocket } from '@/lib/socket';

const ICE_SERVERS = {
  iceServers: [
    { urls: 'stun:stun.l.google.com:19302' },
    { urls: 'stun:stun1.l.google.com:19302' },
  ],
};

export default function AgentSessionPage() {
  const params = useParams<{ id: string }>();
  const id = params.id;
  const { status } = useSession();
  const router = useRouter();
  const [ticket, setTicket] = useState<Ticket | null>(null);
  const [messages, setMessages] = useState<Message[]>([]);
  const [message, setMessage] = useState('');
  const [notes, setNotes] = useState('');
  const [loading, setLoading] = useState(true);
  const [resolving, setResolving] = useState(false);
  const [elapsed, setElapsed] = useState(0);
  const [hasRemoteStream, setHasRemoteStream] = useState(false);
  const chatEndRef = useRef<HTMLDivElement>(null);
  const remoteVideoRef = useRef<HTMLVideoElement>(null);
  const peerConnectionRef = useRef<RTCPeerConnection | null>(null);

  useEffect(() => {
    if (status === 'unauthenticated') router.push('/agent/login');
  }, [status, router]);

  const loadTicket = useCallback(async () => {
    const res = await fetch(`/api/tickets/${id}`);
    if (res.ok) {
      const data = await res.json();
      setTicket(data);
      setMessages(data.messages || []);
      setNotes(data.sessionNotes || '');
    }
    setLoading(false);
  }, [id]);

  useEffect(() => {
    loadTicket();
    const interval = setInterval(loadTicket, 30000);
    return () => clearInterval(interval);
  }, [loadTicket]);

  // Socket.IO + WebRTC setup
  useEffect(() => {
    const socket = getSocket();

    socket.emit('join-room', id);

    // Real-time status updates
    socket.on('ticket:status', (newStatus: string) => {
      setTicket(prev => prev ? { ...prev, status: newStatus as TicketStatus } : prev);
    });

    // Real-time chat messages
    socket.on('chat:message', (msg: Message) => {
      setMessages(prev => {
        if (prev.find(m => m.id === msg.id)) return prev;
        return [...prev, msg];
      });
    });

    // WebRTC: receive screen offer from customer
    socket.on('screen:offer', async (offer: RTCSessionDescriptionInit) => {
      // Close any existing peer connection
      peerConnectionRef.current?.close();

      const pc = new RTCPeerConnection(ICE_SERVERS);
      peerConnectionRef.current = pc;

      pc.onicecandidate = (event) => {
        if (event.candidate) {
          socket.emit('ice:candidate', { ticketId: id, candidate: event.candidate });
        }
      };

      pc.ontrack = (event) => {
        if (remoteVideoRef.current) {
          remoteVideoRef.current.srcObject = event.streams[0];
          setHasRemoteStream(true);
        }
      };

      await pc.setRemoteDescription(new RTCSessionDescription(offer));
      const answer = await pc.createAnswer();
      await pc.setLocalDescription(answer);
      socket.emit('screen:answer', { ticketId: id, answer });
    });

    // ICE candidates from customer
    socket.on('ice:candidate', async (candidate: RTCIceCandidateInit) => {
      if (peerConnectionRef.current && peerConnectionRef.current.signalingState !== 'closed') {
        await peerConnectionRef.current.addIceCandidate(new RTCIceCandidate(candidate));
      }
    });

    return () => {
      socket.off('ticket:status');
      socket.off('chat:message');
      socket.off('screen:offer');
      socket.off('ice:candidate');
      peerConnectionRef.current?.close();
      peerConnectionRef.current = null;
      disconnectSocket();
    };
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  useEffect(() => {
    if (!ticket?.sessionStartedAt) return;
    const timer = setInterval(() => {
      setElapsed(Math.floor((Date.now() - new Date(ticket.sessionStartedAt!).getTime()) / 1000));
    }, 1000);
    return () => clearInterval(timer);
  }, [ticket?.sessionStartedAt]);

  useEffect(() => {
    chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages]);

  async function startSession() {
    await fetch(`/api/tickets/${id}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ status: 'in_session', sessionStartedAt: new Date().toISOString() }),
    });
    getSocket().emit('ticket:status', { ticketId: id, status: 'in_session' });
    await loadTicket();
  }

  async function markResolved() {
    setResolving(true);
    await fetch(`/api/tickets/${id}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        status: 'awaiting_confirmation',
        resolvedAt: new Date().toISOString(),
        sessionNotes: notes,
      }),
    });
    getSocket().emit('ticket:status', { ticketId: id, status: 'awaiting_confirmation' });
    await loadTicket();
    setResolving(false);
  }

  async function saveNotes() {
    await fetch(`/api/tickets/${id}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ sessionNotes: notes }),
    });
  }

  async function sendMessage(e: React.FormEvent) {
    e.preventDefault();
    if (!message.trim()) return;
    const content = message.trim();
    setMessage('');
    const res = await fetch(`/api/messages/${id}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ senderType: 'agent', content }),
    });
    if (res.ok) {
      const msg: Message = await res.json();
      setMessages(prev => [...prev, msg]);
      // Broadcast to customer via socket
      getSocket().emit('chat:message', { ticketId: id, message: msg });
    }
  }

  function formatElapsed(secs: number) {
    const h = Math.floor(secs / 3600);
    const m = Math.floor((secs % 3600) / 60);
    const s = secs % 60;
    return `${h > 0 ? `${h}:` : ''}${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
  }

  if (status === 'loading' || loading) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="w-8 h-8 border-2 border-[#D97757] border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!ticket) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center text-center">
      <p className="text-slate-600">Ticket not found</p>
    </div>
  );

  const purchasedSecs = ticket.hoursPurchased * 3600;
  const timeLeft = Math.max(0, purchasedSecs - elapsed);

  return (
    <div className="min-h-screen bg-slate-900 flex flex-col">
      {/* Top bar */}
      <div className="bg-slate-800 border-b border-slate-700 px-6 py-3 flex items-center justify-between">
        <div className="flex items-center gap-4">
          <Link href="/agent/dashboard" className="text-slate-400 hover:text-white transition-colors">
            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </Link>
          <div>
            <span className="text-white font-medium text-sm">{ticket.ticketNumber}</span>
            <span className="ml-2 text-slate-400 text-sm">· {ticket.customerName}</span>
          </div>
          <span className="px-2 py-0.5 bg-slate-700 text-slate-300 text-xs rounded">{ticket.issueCategory}</span>
        </div>
        <div className="flex items-center gap-4">
          {ticket.sessionStartedAt && (
            <div className="text-sm font-mono">
              <span className="text-slate-400">Elapsed: </span>
              <span className="text-white">{formatElapsed(elapsed)}</span>
              <span className="text-slate-500"> / </span>
              <span className={timeLeft < 600 ? 'text-red-400' : 'text-slate-300'}>{formatElapsed(timeLeft)} left</span>
            </div>
          )}
          {ticket.status === 'assigned' && (
            <button onClick={startSession} className="px-4 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
              Start session
            </button>
          )}
          {ticket.status === 'in_session' && (
            <button onClick={markResolved} disabled={resolving} className="px-4 py-1.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors disabled:opacity-50">
              {resolving ? 'Marking...' : 'Mark as resolved'}
            </button>
          )}
        </div>
      </div>

      <div className="flex flex-1 overflow-hidden">
        {/* Sidebar: ticket info */}
        <div className="w-72 bg-slate-800 border-r border-slate-700 flex flex-col overflow-y-auto">
          <div className="p-4 border-b border-slate-700">
            <h3 className="text-white font-medium text-sm mb-3">Customer details</h3>
            <div className="space-y-2 text-xs">
              <div>
                <span className="text-slate-500">Name</span>
                <p className="text-slate-200 mt-0.5">{ticket.customerName}</p>
              </div>
              <div>
                <span className="text-slate-500">Email</span>
                <p className="text-slate-200 mt-0.5">{ticket.customerEmail}</p>
              </div>
              {ticket.customerPhone && (
                <div>
                  <span className="text-slate-500">Phone</span>
                  <p className="text-slate-200 mt-0.5">{ticket.customerPhone}</p>
                </div>
              )}
            </div>
          </div>
          <div className="p-4 border-b border-slate-700">
            <h3 className="text-white font-medium text-sm mb-2">Issue</h3>
            <p className="text-slate-300 text-xs leading-relaxed">{ticket.issueDescription}</p>
            <div className="flex gap-2 mt-3">
              <span className="px-2 py-0.5 bg-slate-700 text-slate-400 text-xs rounded">{ticket.issueCategory}</span>
              <span className="px-2 py-0.5 bg-slate-700 text-slate-400 text-xs rounded">{ticket.hoursPurchased}h · ${ticket.amountPaid}</span>
            </div>
          </div>
          <div className="p-4 flex-1">
            <h3 className="text-white font-medium text-sm mb-2">Session notes</h3>
            <textarea
              value={notes}
              onChange={e => setNotes(e.target.value)}
              onBlur={saveNotes}
              rows={6}
              placeholder="Add notes about what you did, steps taken, solution found..."
              className="w-full px-3 py-2 bg-slate-700 border border-slate-600 rounded-lg text-slate-200 text-xs placeholder-slate-500 focus:outline-none focus:border-[#D97757] resize-none"
            />
          </div>
        </div>

        {/* Main: screen view area */}
        <div className="flex-1 flex flex-col bg-slate-900 p-6">
          <div className="flex-1 bg-slate-800 rounded-xl overflow-hidden flex items-center justify-center relative">
            {/* Remote video — hidden until stream arrives */}
            <video
              ref={remoteVideoRef}
              autoPlay
              className={`w-full h-full object-contain ${hasRemoteStream ? 'block' : 'hidden'}`}
            />

            {/* Placeholder shown until stream arrives */}
            {!hasRemoteStream && (
              <div className="text-center max-w-md">
                <div className="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                  <svg className="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
                  </svg>
                </div>
                <h3 className="text-white font-medium mb-2">Waiting for customer&apos;s screen</h3>
                <p className="text-slate-400 text-sm mb-4">The customer needs to click &ldquo;Start screen sharing&rdquo; on their end.</p>
                <div className="mt-4 p-3 bg-slate-700 rounded-lg text-left">
                  <p className="text-xs text-slate-500 font-medium mb-1">Status: {ticket.status.replace(/_/g, ' ')}</p>
                  <p className="text-xs text-slate-500">Screen sharing will appear here once the customer grants permission.</p>
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Chat sidebar */}
        <div className="w-80 bg-slate-800 border-l border-slate-700 flex flex-col">
          <div className="p-4 border-b border-slate-700">
            <h3 className="text-white font-medium text-sm">Chat</h3>
          </div>
          <div className="flex-1 overflow-y-auto p-4 space-y-3">
            {messages.length === 0 ? (
              <p className="text-slate-500 text-xs text-center mt-4">No messages yet.</p>
            ) : (
              messages.map(msg => (
                <div key={msg.id} className={`flex ${msg.senderType === 'agent' ? 'justify-end' : 'justify-start'}`}>
                  <div className={`max-w-[80%] px-3 py-2 rounded-lg text-xs ${
                    msg.senderType === 'agent'
                      ? 'bg-[#D97757] text-white'
                      : 'bg-slate-700 text-slate-200'
                  }`}>
                    <div className="font-medium mb-0.5 opacity-70">{msg.senderType === 'agent' ? 'You' : ticket.customerName}</div>
                    {msg.content}
                  </div>
                </div>
              ))
            )}
            <div ref={chatEndRef} />
          </div>
          <form onSubmit={sendMessage} className="p-4 border-t border-slate-700 flex gap-2">
            <input
              type="text"
              value={message}
              onChange={e => setMessage(e.target.value)}
              placeholder="Type a message..."
              className="flex-1 px-3 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white text-xs placeholder-slate-500 focus:outline-none focus:border-[#D97757]"
            />
            <button type="submit" className="px-3 py-2 bg-[#D97757] text-white rounded-lg hover:bg-[#c4673e] transition-colors">
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}

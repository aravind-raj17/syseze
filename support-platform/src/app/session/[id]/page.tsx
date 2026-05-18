'use client';
import { useState, useEffect, useRef, useCallback } from 'react';
import { useParams } from 'next/navigation';
import Link from 'next/link';
import { Ticket, Message } from '@/types';

const STATUS_LABELS: Record<string, { label: string; color: string }> = {
  paid: { label: 'Waiting for payment confirmation', color: 'text-yellow-600 bg-yellow-50' },
  queued: { label: 'Waiting for an agent', color: 'text-blue-600 bg-blue-50' },
  assigned: { label: 'Agent is connecting...', color: 'text-orange-600 bg-orange-50' },
  in_session: { label: 'Session in progress', color: 'text-green-600 bg-green-50' },
  awaiting_confirmation: { label: 'Please confirm resolution', color: 'text-purple-600 bg-purple-50' },
  resolved: { label: 'Session resolved', color: 'text-slate-600 bg-slate-100' },
};

export default function CustomerSessionPage() {
  const params = useParams<{ id: string }>();
  const id = params.id;
  const [ticket, setTicket] = useState<Ticket | null>(null);
  const [messages, setMessages] = useState<Message[]>([]);
  const [message, setMessage] = useState('');
  const [loading, setLoading] = useState(true);
  const [confirming, setConfirming] = useState(false);
  const [screenStream, setScreenStream] = useState<MediaStream | null>(null);
  const [screenError, setScreenError] = useState('');
  const localVideoRef = useRef<HTMLVideoElement>(null);
  const chatEndRef = useRef<HTMLDivElement>(null);

  const loadTicket = useCallback(async () => {
    const res = await fetch(`/api/tickets/${id}`);
    if (res.ok) {
      const data = await res.json();
      setTicket(data);
      setMessages(data.messages || []);
    }
    setLoading(false);
  }, [id]);

  useEffect(() => {
    loadTicket();
    const interval = setInterval(loadTicket, 5000);
    return () => clearInterval(interval);
  }, [loadTicket]);

  useEffect(() => {
    chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages]);

  async function startScreenShare() {
    setScreenError('');
    try {
      const stream = await navigator.mediaDevices.getDisplayMedia({
        video: { frameRate: 15 },
        audio: false,
      });
      setScreenStream(stream);
      if (localVideoRef.current) {
        localVideoRef.current.srcObject = stream;
      }
      stream.getVideoTracks()[0].addEventListener('ended', () => {
        setScreenStream(null);
      });
    } catch (err: unknown) {
      if (err instanceof Error && err.name !== 'NotAllowedError') {
        setScreenError('Failed to start screen sharing. Please try again.');
      } else {
        setScreenError('Screen sharing permission was denied. Please allow screen sharing to continue.');
      }
    }
  }

  function stopScreenShare() {
    screenStream?.getTracks().forEach(t => t.stop());
    setScreenStream(null);
  }

  async function sendMessage(e: React.FormEvent) {
    e.preventDefault();
    if (!message.trim()) return;
    const content = message.trim();
    setMessage('');
    const res = await fetch(`/api/messages/${id}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ senderType: 'customer', content }),
    });
    if (res.ok) {
      const msg = await res.json();
      setMessages(prev => [...prev, msg]);
    }
  }

  async function confirmResolution() {
    setConfirming(true);
    await fetch(`/api/tickets/${id}`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ status: 'resolved', customerConfirmedAt: new Date().toISOString() }),
    });
    await loadTicket();
    setConfirming(false);
  }

  if (loading) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="w-8 h-8 border-2 border-[#D97757] border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!ticket) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center text-center">
      <div>
        <p className="text-slate-600 mb-4">Session not found</p>
        <Link href="/book" className="text-[#D97757] font-medium">Book a new session</Link>
      </div>
    </div>
  );

  const statusInfo = STATUS_LABELS[ticket.status] || { label: ticket.status, color: 'text-slate-600 bg-slate-100' };
  const isActive = ['in_session', 'assigned', 'awaiting_confirmation'].includes(ticket.status);

  return (
    <div className="min-h-screen bg-slate-900 flex flex-col">
      {/* Top bar */}
      <div className="bg-slate-800 border-b border-slate-700 px-6 py-3 flex items-center justify-between">
        <Link href="/" className="flex items-center gap-2">
          <div className="w-6 h-6 rounded bg-[#D97757]" />
          <span className="font-semibold text-white text-sm">TechSupport Pro</span>
        </Link>
        <div className="flex items-center gap-3">
          <span className={`px-3 py-1 rounded-full text-xs font-medium ${statusInfo.color}`}>{statusInfo.label}</span>
          <span className="text-slate-400 text-xs font-mono">{ticket.ticketNumber}</span>
        </div>
      </div>

      <div className="flex flex-1 overflow-hidden">
        {/* Main area */}
        <div className="flex-1 flex flex-col p-6">
          {/* Waiting state */}
          {ticket.status === 'queued' && (
            <div className="flex-1 flex items-center justify-center">
              <div className="text-center max-w-md">
                <div className="w-16 h-16 border-[3px] border-[#D97757] border-t-transparent rounded-full animate-spin mx-auto mb-6" />
                <h2 className="text-white text-xl font-semibold mb-3">Looking for an available expert...</h2>
                <p className="text-slate-400 text-sm mb-6">Usually under 5 minutes. We&apos;ll notify you as soon as someone accepts your ticket.</p>
                <div className="bg-slate-800 rounded-xl p-4 text-left">
                  <div className="text-xs text-slate-500 mb-2">YOUR ISSUE</div>
                  <p className="text-slate-300 text-sm">{ticket.issueDescription}</p>
                  <div className="mt-3 flex items-center gap-2">
                    <span className="px-2 py-0.5 bg-slate-700 text-slate-400 text-xs rounded">{ticket.issueCategory}</span>
                    <span className="px-2 py-0.5 bg-slate-700 text-slate-400 text-xs rounded">{ticket.hoursPurchased}h purchased</span>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* Screen share area */}
          {isActive && (
            <div className="flex-1 flex flex-col">
              <div className="flex-1 bg-slate-800 rounded-xl overflow-hidden flex items-center justify-center relative">
                {screenStream ? (
                  <video ref={localVideoRef} autoPlay muted className="w-full h-full object-contain" />
                ) : (
                  <div className="text-center p-8">
                    <div className="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                      <svg className="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
                      </svg>
                    </div>
                    <h3 className="text-white font-medium mb-2">Share your screen</h3>
                    <p className="text-slate-400 text-sm mb-6 max-w-xs">Your expert needs to see your screen to help you. Click below to start sharing.</p>
                    {screenError && (
                      <div className="mb-4 p-3 bg-red-900/30 border border-red-700 rounded-lg text-red-300 text-sm">{screenError}</div>
                    )}
                    {/* TODO: For real remote control (not just viewing), a native agent like RustDesk or AnyDesk is required.
                         Browser WebRTC via getDisplayMedia() is view-only — it cannot send mouse/keyboard events.
                         To implement true remote control: integrate a Rust/Electron desktop agent that exposes a WebSocket for control events. */}
                    <button
                      onClick={startScreenShare}
                      className="px-6 py-3 bg-[#D97757] text-white font-medium rounded-lg hover:bg-[#c4673e] transition-colors"
                    >
                      Start screen sharing
                    </button>
                  </div>
                )}
                {screenStream && (
                  <div className="absolute bottom-4 right-4">
                    <button
                      onClick={stopScreenShare}
                      className="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors"
                    >
                      Stop sharing
                    </button>
                  </div>
                )}
              </div>

              {ticket.status === 'awaiting_confirmation' && (
                <div className="mt-4 p-4 bg-purple-900/30 border border-purple-700 rounded-xl flex items-center justify-between">
                  <div>
                    <p className="text-purple-200 font-medium text-sm">Your expert marked this issue as resolved</p>
                    <p className="text-purple-400 text-xs mt-0.5">Please confirm if your problem has been fixed.</p>
                  </div>
                  <button
                    onClick={confirmResolution}
                    disabled={confirming}
                    className="ml-4 px-5 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors disabled:opacity-50 whitespace-nowrap"
                  >
                    {confirming ? 'Confirming...' : "Yes, it's fixed!"}
                  </button>
                </div>
              )}
            </div>
          )}

          {ticket.status === 'resolved' && (
            <div className="flex-1 flex items-center justify-center">
              <div className="text-center">
                <div className="w-16 h-16 bg-green-900/30 border border-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                  <svg className="w-8 h-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <h2 className="text-white text-xl font-semibold mb-2">Issue resolved!</h2>
                <p className="text-slate-400 text-sm mb-6">Your session has ended. Thank you for using TechSupport Pro.</p>
                <Link href="/book" className="px-6 py-3 bg-[#D97757] text-white font-medium rounded-lg hover:bg-[#c4673e] transition-colors">
                  Book another session
                </Link>
              </div>
            </div>
          )}
        </div>

        {/* Chat sidebar */}
        <div className="w-80 bg-slate-800 border-l border-slate-700 flex flex-col">
          <div className="p-4 border-b border-slate-700">
            <h3 className="text-white font-medium text-sm">Session chat</h3>
            <p className="text-slate-400 text-xs mt-0.5">{ticket.ticketNumber} · {ticket.issueCategory}</p>
          </div>
          <div className="flex-1 overflow-y-auto p-4 space-y-3">
            {messages.length === 0 ? (
              <p className="text-slate-500 text-xs text-center mt-4">No messages yet. Use chat to communicate with your agent.</p>
            ) : (
              messages.map(msg => (
                <div key={msg.id} className={`flex ${msg.senderType === 'customer' ? 'justify-end' : 'justify-start'}`}>
                  <div className={`max-w-[80%] px-3 py-2 rounded-lg text-xs ${
                    msg.senderType === 'customer'
                      ? 'bg-[#D97757] text-white'
                      : 'bg-slate-700 text-slate-200'
                  }`}>
                    <div className="font-medium mb-0.5 opacity-70">{msg.senderType === 'customer' ? 'You' : 'Agent'}</div>
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

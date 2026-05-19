'use client';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { PRICE_PER_HOUR, HOURS_OPTIONS, ISSUE_CATEGORIES } from '@/types';

export default function BookPage() {
  const router = useRouter();
  const [form, setForm] = useState({
    customerName: '',
    customerEmail: '',
    customerPhone: '',
    issueCategory: '',
    issueDescription: '',
    hoursPurchased: 1,
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const total = form.hoursPurchased * PRICE_PER_HOUR;

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError('');
    if (form.issueDescription.length < 20) {
      setError('Please describe your issue in at least 20 characters.');
      return;
    }
    setLoading(true);
    try {
      const res = await fetch('/api/tickets', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form),
      });
      if (!res.ok) throw new Error('Failed to create ticket');
      const ticket = await res.json();
      router.push(`/checkout?ticketId=${ticket.id}`);
    } catch {
      setError('Something went wrong. Please try again.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="min-h-screen bg-slate-50">
      <nav className="bg-white border-b border-slate-100 px-6 py-4">
        <div className="max-w-3xl mx-auto flex items-center justify-between">
          <Link href="/" className="flex items-center gap-2">
            <div className="w-7 h-7 rounded-lg bg-[#D97757] flex items-center justify-center">
              <svg className="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
              </svg>
            </div>
            <span className="font-semibold text-slate-900">TechSupport Pro</span>
          </Link>
          <div className="flex items-center gap-2 text-sm text-slate-500">
            <span className="w-6 h-6 rounded-full bg-[#D97757] text-white flex items-center justify-center text-xs font-bold">1</span>
            <span className="font-medium text-slate-700">Describe issue</span>
            <svg className="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7"/></svg>
            <span className="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">2</span>
            <span>Payment</span>
            <svg className="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7"/></svg>
            <span className="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">3</span>
            <span>Session</span>
          </div>
        </div>
      </nav>

      <div className="max-w-3xl mx-auto px-6 py-12">
        <div className="mb-10">
          <h1 className="text-2xl font-bold text-slate-900 mb-2">Book a support session</h1>
          <p className="text-slate-500">Tell us about your issue and an expert will connect with you shortly.</p>
        </div>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 className="font-semibold text-slate-900 mb-5">Your details</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1.5">Full name <span className="text-red-500">*</span></label>
                <input
                  type="text"
                  required
                  value={form.customerName}
                  onChange={e => setForm(f => ({ ...f, customerName: e.target.value }))}
                  className="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D97757]/20 focus:border-[#D97757] transition-colors"
                  placeholder="Jane Smith"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1.5">Email address <span className="text-red-500">*</span></label>
                <input
                  type="email"
                  required
                  value={form.customerEmail}
                  onChange={e => setForm(f => ({ ...f, customerEmail: e.target.value }))}
                  className="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D97757]/20 focus:border-[#D97757] transition-colors"
                  placeholder="jane@example.com"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1.5">Phone number <span className="text-slate-400 font-normal">(optional)</span></label>
                <input
                  type="tel"
                  value={form.customerPhone}
                  onChange={e => setForm(f => ({ ...f, customerPhone: e.target.value }))}
                  className="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D97757]/20 focus:border-[#D97757] transition-colors"
                  placeholder="+1 (555) 000-0000"
                />
              </div>
            </div>
          </div>

          <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 className="font-semibold text-slate-900 mb-5">Your issue</h2>
            <div className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1.5">Issue category <span className="text-red-500">*</span></label>
                <select
                  required
                  value={form.issueCategory}
                  onChange={e => setForm(f => ({ ...f, issueCategory: e.target.value }))}
                  className="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D97757]/20 focus:border-[#D97757] transition-colors bg-white"
                >
                  <option value="">Select a category...</option>
                  {ISSUE_CATEGORIES.map(cat => (
                    <option key={cat} value={cat}>{cat}</option>
                  ))}
                </select>
              </div>
              <div>
                <label className="block text-sm font-medium text-slate-700 mb-1.5">
                  Issue description <span className="text-red-500">*</span>
                  <span className="ml-2 text-slate-400 font-normal">({form.issueDescription.length} chars, min 20)</span>
                </label>
                <textarea
                  required
                  value={form.issueDescription}
                  onChange={e => setForm(f => ({ ...f, issueDescription: e.target.value }))}
                  rows={4}
                  className="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D97757]/20 focus:border-[#D97757] transition-colors resize-none"
                  placeholder="Describe what's happening in detail. Include any error messages you see, when it started, and what you've already tried..."
                />
              </div>
            </div>
          </div>

          <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 className="font-semibold text-slate-900 mb-5">Session duration</h2>
            <div className="grid grid-cols-3 md:grid-cols-6 gap-3 mb-4">
              {HOURS_OPTIONS.map(hours => (
                <button
                  key={hours}
                  type="button"
                  onClick={() => setForm(f => ({ ...f, hoursPurchased: hours }))}
                  className={`py-3 rounded-xl border text-sm font-medium transition-all ${
                    form.hoursPurchased === hours
                      ? 'border-[#D97757] bg-orange-50 text-[#D97757]'
                      : 'border-slate-200 text-slate-700 hover:border-slate-300'
                  }`}
                >
                  {hours}h
                </button>
              ))}
            </div>
            <div className="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
              <div className="text-sm text-slate-600">
                {form.hoursPurchased} hour{form.hoursPurchased > 1 ? 's' : ''} × ${PRICE_PER_HOUR}/hr
              </div>
              <div className="text-2xl font-bold text-slate-900">${total}</div>
            </div>
          </div>

          {error && (
            <div className="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">{error}</div>
          )}

          <button
            type="submit"
            disabled={loading}
            className="w-full py-4 bg-[#D97757] text-white font-semibold rounded-xl hover:bg-[#c4673e] transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-sm"
          >
            {loading ? 'Creating your ticket...' : `Continue to payment — $${total}`}
          </button>
        </form>
      </div>
    </div>
  );
}

'use client';
import { useState, useEffect, Suspense } from 'react';
import { useSearchParams, useRouter } from 'next/navigation';
import Link from 'next/link';
import { Ticket, PRICE_PER_HOUR } from '@/types';

function CheckoutContent() {
  const searchParams = useSearchParams();
  const router = useRouter();
  const ticketId = searchParams.get('ticketId');
  const [ticket, setTicket] = useState<Ticket | null>(null);
  const [loading, setLoading] = useState(true);
  const [paying, setPaying] = useState(false);
  const [paid, setPaid] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    if (!ticketId) return;
    fetch(`/api/tickets/${ticketId}`)
      .then(r => r.json())
      .then(data => { setTicket(data); setLoading(false); })
      .catch(() => { setError('Ticket not found'); setLoading(false); });
  }, [ticketId]);

  async function handlePay() {
    if (!ticketId) return;
    setPaying(true);
    try {
      const res = await fetch('/api/payments', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ticketId }),
      });
      if (!res.ok) throw new Error('Payment failed');
      setPaid(true);
      setTimeout(() => router.push(`/session/${ticketId}`), 2000);
    } catch {
      setError('Payment failed. Please try again.');
    } finally {
      setPaying(false);
    }
  }

  if (loading) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="w-8 h-8 border-2 border-[#D97757] border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!ticket) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="text-center">
        <p className="text-slate-600 mb-4">Ticket not found</p>
        <Link href="/book" className="text-[#D97757] font-medium">Book a new session</Link>
      </div>
    </div>
  );

  if (paid) return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center">
      <div className="text-center">
        <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg className="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h2 className="text-xl font-bold text-slate-900 mb-2">Payment successful!</h2>
        <p className="text-slate-500 text-sm">Redirecting to your session room...</p>
      </div>
    </div>
  );

  return (
    <div className="min-h-screen bg-slate-50">
      <nav className="bg-white border-b border-slate-100 px-6 py-4">
        <div className="max-w-3xl mx-auto flex items-center justify-between">
          <Link href="/" className="flex items-center gap-2">
            <div className="w-7 h-7 rounded-lg bg-[#D97757]" />
            <span className="font-semibold text-slate-900">TechSupport Pro</span>
          </Link>
          <div className="flex items-center gap-2 text-sm text-slate-500">
            <span className="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">1</span>
            <span>Describe issue</span>
            <svg className="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7"/></svg>
            <span className="w-6 h-6 rounded-full bg-[#D97757] text-white flex items-center justify-center text-xs font-bold">2</span>
            <span className="font-medium text-slate-700">Payment</span>
            <svg className="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7"/></svg>
            <span className="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">3</span>
            <span>Session</span>
          </div>
        </div>
      </nav>

      <div className="max-w-3xl mx-auto px-6 py-12">
        <h1 className="text-2xl font-bold text-slate-900 mb-8">Complete payment</h1>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 className="font-semibold text-slate-900 mb-4">Order summary</h2>
            <div className="space-y-3 text-sm">
              <div className="flex justify-between">
                <span className="text-slate-500">Ticket</span>
                <span className="font-mono text-slate-700">{ticket.ticketNumber}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-slate-500">Customer</span>
                <span className="text-slate-700">{ticket.customerName}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-slate-500">Category</span>
                <span className="text-slate-700">{ticket.issueCategory}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-slate-500">Duration</span>
                <span className="text-slate-700">{ticket.hoursPurchased} hour{ticket.hoursPurchased > 1 ? 's' : ''}</span>
              </div>
              <div className="border-t border-slate-100 pt-3 flex justify-between">
                <span className="text-slate-500">Rate</span>
                <span className="text-slate-700">${PRICE_PER_HOUR}/hr</span>
              </div>
              <div className="flex justify-between font-semibold text-base">
                <span>Total</span>
                <span className="text-[#D97757]">${ticket.amountPaid}</span>
              </div>
            </div>

            <div className="mt-4 p-3 bg-slate-50 rounded-lg">
              <p className="text-xs text-slate-500 leading-relaxed">{ticket.issueDescription}</p>
            </div>
          </div>

          <div className="space-y-4">
            {/* TODO: integrate real payment provider (Stripe/Razorpay)
              Replace this entire mock section with:
              1. Load Stripe.js: const stripe = await loadStripe(process.env.NEXT_PUBLIC_STRIPE_KEY)
              2. Create PaymentIntent on server: POST /api/payments/intent
              3. Mount Stripe Elements: <PaymentElement />
              4. On submit: await stripe.confirmPayment({ elements, redirectUrl })
              The mock below simulates a 2s processing delay and marks the payment complete.
            */}
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
              <h2 className="font-semibold text-slate-900 mb-4">Payment (Demo)</h2>
              <div className="p-3 bg-amber-50 border border-amber-200 rounded-lg mb-4">
                <p className="text-xs text-amber-700 font-medium">This is a demo — no real payment is processed.</p>
              </div>
              <div className="space-y-3">
                <div>
                  <label className="block text-xs font-medium text-slate-700 mb-1">Card number</label>
                  <input type="text" disabled defaultValue="4242 4242 4242 4242" className="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-400" />
                </div>
                <div className="grid grid-cols-2 gap-3">
                  <div>
                    <label className="block text-xs font-medium text-slate-700 mb-1">Expiry</label>
                    <input type="text" disabled defaultValue="12/28" className="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-400" />
                  </div>
                  <div>
                    <label className="block text-xs font-medium text-slate-700 mb-1">CVC</label>
                    <input type="text" disabled defaultValue="***" className="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-400" />
                  </div>
                </div>
              </div>
            </div>

            {error && (
              <div className="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">{error}</div>
            )}

            <button
              onClick={handlePay}
              disabled={paying}
              className="w-full py-4 bg-[#D97757] text-white font-semibold rounded-xl hover:bg-[#c4673e] transition-colors disabled:opacity-50 flex items-center justify-center gap-2"
            >
              {paying ? (
                <>
                  <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" />
                  Processing...
                </>
              ) : (
                `Pay $${ticket.amountPaid}`
              )}
            </button>

            <div className="flex items-center justify-center gap-2 text-xs text-slate-400">
              <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              Secured with 256-bit encryption
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default function CheckoutPage() {
  return (
    <Suspense fallback={<div className="min-h-screen bg-slate-50 flex items-center justify-center"><div className="w-8 h-8 border-2 border-[#D97757] border-t-transparent rounded-full animate-spin" /></div>}>
      <CheckoutContent />
    </Suspense>
  );
}

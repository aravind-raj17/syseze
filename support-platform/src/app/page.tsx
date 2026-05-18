import Link from 'next/link';
import { PRICE_PER_HOUR, HOURS_OPTIONS, ISSUE_CATEGORIES } from '@/types';

export default function HomePage() {
  return (
    <div className="min-h-screen bg-white">
      {/* Nav */}
      <nav className="border-b border-slate-100 px-6 py-4">
        <div className="max-w-6xl mx-auto flex items-center justify-between">
          <div className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg bg-[#D97757] flex items-center justify-center">
              <svg className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
              </svg>
            </div>
            <span className="font-semibold text-slate-900">TechSupport Pro</span>
          </div>
          <div className="flex items-center gap-6">
            <Link href="#pricing" className="text-sm text-slate-600 hover:text-slate-900 transition-colors">Pricing</Link>
            <Link href="#how-it-works" className="text-sm text-slate-600 hover:text-slate-900 transition-colors">How it works</Link>
            <Link href="/agent/login" className="text-sm text-slate-600 hover:text-slate-900 transition-colors">Agent login</Link>
            <Link href="/book" className="px-4 py-2 bg-[#D97757] text-white text-sm font-medium rounded-lg hover:bg-[#c4673e] transition-colors">
              Get Support
            </Link>
          </div>
        </div>
      </nav>

      {/* Hero */}
      <section className="max-w-6xl mx-auto px-6 pt-20 pb-24 text-center">
        <div className="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-50 text-[#D97757] text-sm font-medium rounded-full mb-6">
          <span className="w-1.5 h-1.5 rounded-full bg-[#D97757] animate-pulse"></span>
          Experts available now
        </div>
        <h1 className="text-5xl font-bold text-slate-900 leading-tight mb-6">
          Expert tech support,<br />
          <span className="text-[#D97757]">on your screen in minutes</span>
        </h1>
        <p className="text-xl text-slate-500 max-w-2xl mx-auto mb-10">
          Describe your issue, pick your hours, pay once. A certified technician connects remotely and fixes the problem — guaranteed.
        </p>
        <div className="flex items-center justify-center gap-4">
          <Link href="/book" className="px-8 py-4 bg-[#D97757] text-white font-semibold rounded-xl hover:bg-[#c4673e] transition-colors shadow-lg shadow-orange-200">
            Get Support Now — from ${PRICE_PER_HOUR}/hr
          </Link>
          <a href="#how-it-works" className="px-8 py-4 text-slate-700 font-medium rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors">
            See how it works
          </a>
        </div>
        <div className="flex items-center justify-center gap-8 mt-12 text-sm text-slate-500">
          <div className="flex items-center gap-2">
            <svg className="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"/></svg>
            No software to install
          </div>
          <div className="flex items-center gap-2">
            <svg className="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"/></svg>
            Secure, encrypted session
          </div>
          <div className="flex items-center gap-2">
            <svg className="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"/></svg>
            Money-back guarantee
          </div>
        </div>
      </section>

      {/* How it works */}
      <section id="how-it-works" className="bg-slate-50 py-20 px-6">
        <div className="max-w-6xl mx-auto">
          <div className="text-center mb-14">
            <h2 className="text-3xl font-bold text-slate-900 mb-3">How it works</h2>
            <p className="text-slate-500">Three simple steps to get your issue resolved</p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {[
              { step: '01', title: 'Describe your issue', desc: "Tell us what's going wrong. Choose a category, describe the problem, and pick how many hours you think you'll need.", icon: '📝' },
              { step: '02', title: 'Pay & get your link', desc: "Complete a quick, secure payment. You'll instantly receive a unique session link via email.", icon: '💳' },
              { step: '03', title: 'Expert joins & fixes it', desc: 'A certified technician accepts your ticket, joins your session, and walks through the fix with you.', icon: '🔧' },
            ].map(item => (
              <div key={item.step} className="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div className="text-3xl mb-4">{item.icon}</div>
                <div className="text-xs font-bold text-[#D97757] mb-2 tracking-widest">STEP {item.step}</div>
                <h3 className="text-lg font-semibold text-slate-900 mb-3">{item.title}</h3>
                <p className="text-slate-500 text-sm leading-relaxed">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Pricing */}
      <section id="pricing" className="py-20 px-6">
        <div className="max-w-4xl mx-auto">
          <div className="text-center mb-14">
            <h2 className="text-3xl font-bold text-slate-900 mb-3">Simple, transparent pricing</h2>
            <p className="text-slate-500">Pay only for the time you need. No subscriptions, no hidden fees.</p>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
            {HOURS_OPTIONS.map(hours => (
              <div key={hours} className={`rounded-2xl p-6 border ${hours === 2 ? 'border-[#D97757] bg-orange-50' : 'border-slate-200 bg-white'}`}>
                {hours === 2 && <div className="text-xs font-bold text-[#D97757] mb-2">MOST POPULAR</div>}
                <div className="text-3xl font-bold text-slate-900 mb-1">{hours}h</div>
                <div className="text-2xl font-semibold text-[#D97757] mb-1">${hours * PRICE_PER_HOUR}</div>
                <div className="text-sm text-slate-500">${PRICE_PER_HOUR}/hr × {hours} hours</div>
              </div>
            ))}
          </div>
          <div className="text-center mt-10">
            <Link href="/book" className="inline-flex px-8 py-4 bg-[#D97757] text-white font-semibold rounded-xl hover:bg-[#c4673e] transition-colors">
              Book a session
            </Link>
          </div>
        </div>
      </section>

      {/* Categories */}
      <section className="bg-slate-50 py-16 px-6">
        <div className="max-w-4xl mx-auto text-center">
          <h2 className="text-2xl font-bold text-slate-900 mb-8">We support all major platforms</h2>
          <div className="flex flex-wrap justify-center gap-3">
            {ISSUE_CATEGORIES.map(cat => (
              <span key={cat} className="px-4 py-2 bg-white border border-slate-200 rounded-full text-sm text-slate-700 font-medium">
                {cat}
              </span>
            ))}
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="border-t border-slate-100 py-10 px-6">
        <div className="max-w-6xl mx-auto flex items-center justify-between text-sm text-slate-500">
          <div className="flex items-center gap-2">
            <div className="w-6 h-6 rounded bg-[#D97757] flex items-center justify-center">
              <svg className="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
              </svg>
            </div>
            <span className="font-medium text-slate-700">TechSupport Pro</span>
          </div>
          <span>© {new Date().getFullYear()} TechSupport Pro. All rights reserved.</span>
        </div>
      </footer>
    </div>
  );
}

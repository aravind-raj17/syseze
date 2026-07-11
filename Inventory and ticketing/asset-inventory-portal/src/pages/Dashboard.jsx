import { useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useClients } from '../hooks/useClients';
import { useAssetCounts } from '../hooks/useAssetCounts';

export default function Dashboard() {
  const { clients, loading } = useClients();
  const [search, setSearch] = useState('');
  const navigate = useNavigate();

  const clientIds = useMemo(() => clients.map((c) => c.id), [clients]);
  const counts = useAssetCounts(clientIds);

  const filtered = useMemo(() => {
    const q = search.trim().toLowerCase();
    if (!q) return clients;
    return clients.filter(
      (c) => c.name.toLowerCase().includes(q) || c.code.toLowerCase().includes(q)
    );
  }, [clients, search]);

  return (
    <div className="mx-auto flex max-w-[1140px] flex-col gap-6 p-6">
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 className="text-xl font-semibold text-slate-900">Clients</h1>
          <p className="text-sm text-slate-500">Select a client to manage their asset inventory.</p>
        </div>
        <input
          type="search"
          placeholder="Search clients…"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          className="input w-64"
        />
      </div>

      {loading ? (
        <p className="text-sm text-slate-500">Loading clients…</p>
      ) : (
        <div className="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-4">
          {filtered.map((c) => {
            const count = counts[c.id] ?? 0;
            return (
              <button
                key={c.id}
                type="button"
                onClick={() => navigate(`/clients/${c.id}`)}
                className="flex flex-col gap-2 rounded-xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:shadow-md"
              >
                <div className="flex items-center justify-between gap-2">
                  <span className="text-xs font-semibold uppercase tracking-wide text-blue-600">{c.code}</span>
                  {!c.active && (
                    <span className="rounded-full bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-600">Inactive</span>
                  )}
                </div>
                <div className="text-base font-semibold text-slate-900">{c.name}</div>
                <p className="text-sm text-slate-500">{c.contactPerson}</p>
                <div className="text-xs text-slate-400">{count === 1 ? '1 asset' : `${count} assets`}</div>
              </button>
            );
          })}
        </div>
      )}

      {!loading && filtered.length === 0 && (
        <p className="text-sm text-slate-500">No clients match "{search}".</p>
      )}
    </div>
  );
}

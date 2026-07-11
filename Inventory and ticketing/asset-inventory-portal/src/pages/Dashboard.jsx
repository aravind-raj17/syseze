import { useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useClients } from '../hooks/useClients';
import { useAssetCounts } from '../hooks/useAssetCounts';
import { useAllAssets } from '../hooks/useAllAssets';
import { useTickets } from '../hooks/useTickets';
import { countByCategory, countByStatus, countByClient } from '../lib/assetStats';
import { CATEGORY_ICONS, ClientsIcon, TicketIcon } from '../components/icons';
import StatTile from '../components/StatTile';
import DonutChart from '../components/DonutChart';
import HorizontalBarChart from '../components/HorizontalBarChart';

const CATEGORY_TILE_COLORS = {
  Laptop: 'blue',
  Desktop: 'aqua',
  Monitor: 'magenta',
  Mouse: 'orange',
  Keyboard: 'yellow',
  Headset: 'red',
  Mobile: 'green',
  'Network Gear': 'blue',
  Server: 'violet',
  Printer: 'aqua',
  CCTV: 'magenta',
};

// Matches the hex used in StatusBadge's Tailwind classes, so the donut
// segments read as the same status colors as the badges elsewhere in the app.
const STATUS_COLORS = {
  Active: '#22c55e',
  Available: '#14b8a6',
  'In Repair': '#f59e0b',
  Retired: '#94a3b8',
  Spare: '#3b82f6',
};

export default function Dashboard() {
  const { clients, loading } = useClients();
  const { assets, loading: assetsLoading } = useAllAssets();
  const { tickets } = useTickets();
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

  const categoryCounts = useMemo(() => countByCategory(assets), [assets]);
  const statusCounts = useMemo(() => countByStatus(assets), [assets]);
  const clientCounts = useMemo(() => countByClient(assets, clients), [assets, clients]);
  const openTicketCount = useMemo(
    () => tickets.filter((t) => t.status !== 'Solved' && t.status !== 'Closed').length,
    [tickets]
  );

  const categoryTileValue = (category) => categoryCounts.find((c) => c.label === category)?.value ?? 0;

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-8 p-6">
      <div>
        <h1 className="text-xl font-semibold text-slate-900 dark:text-white">Overview</h1>
        <p className="text-sm text-slate-500 dark:text-slate-400">Assets and tickets across every client.</p>
      </div>

      {assetsLoading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading overview…</p>
      ) : (
        <>
          <div className="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            <StatTile label="Clients" value={clients.length} icon={ClientsIcon} color="violet" />
            {Object.entries(CATEGORY_ICONS).map(([category, Icon]) => (
              <StatTile
                key={category}
                label={category}
                value={categoryTileValue(category)}
                icon={Icon}
                color={CATEGORY_TILE_COLORS[category]}
              />
            ))}
            <StatTile label="Open tickets" value={openTicketCount} icon={TicketIcon} color="red" />
          </div>

          <div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <DonutChart title="Assets by status" totalLabel="Assets" segments={statusCounts.map((s) => ({ ...s, color: STATUS_COLORS[s.label] }))} />
            <HorizontalBarChart title="Assets by client" rows={clientCounts} />
          </div>
          <HorizontalBarChart title="Assets by category" rows={categoryCounts} />
        </>
      )}

      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-4">
          <div>
            <h2 className="text-lg font-semibold text-slate-900 dark:text-white">Clients</h2>
            <p className="text-sm text-slate-500 dark:text-slate-400">Select a client to manage their asset inventory.</p>
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
          <p className="text-sm text-slate-500 dark:text-slate-400">Loading clients…</p>
        ) : (
          <div className="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-4">
            {filtered.map((c) => {
              const count = counts[c.id] ?? 0;
              return (
                <button
                  key={c.id}
                  type="button"
                  onClick={() => navigate(`/clients/${c.id}`)}
                  className="flex flex-col gap-2 rounded-xl border border-slate-200 bg-white p-4 text-left shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-slate-700"
                >
                  <div className="flex items-center justify-between gap-2">
                    <span className="text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">{c.code}</span>
                    {!c.active && (
                      <span className="rounded-full bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-600 dark:bg-slate-700 dark:text-slate-300">Inactive</span>
                    )}
                  </div>
                  <div className="text-base font-semibold text-slate-900 dark:text-white">{c.name}</div>
                  <p className="text-sm text-slate-500 dark:text-slate-400">{c.contactPerson}</p>
                  <div className="text-xs text-slate-400 dark:text-slate-500">{count === 1 ? '1 asset' : `${count} assets`}</div>
                </button>
              );
            })}
          </div>
        )}

        {!loading && filtered.length === 0 && (
          <p className="text-sm text-slate-500 dark:text-slate-400">No clients match "{search}".</p>
        )}
      </div>
    </div>
  );
}

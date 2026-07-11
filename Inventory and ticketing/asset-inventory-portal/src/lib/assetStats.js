import { CATEGORIES, STATUSES } from '../constants';

export function countByCategory(assets) {
  const counts = Object.fromEntries(CATEGORIES.map((c) => [c, 0]));
  for (const a of assets) {
    if (counts[a.category] !== undefined) counts[a.category] += 1;
  }
  return CATEGORIES.map((category) => ({ label: category, value: counts[category] }));
}

export function countByStatus(assets) {
  const counts = Object.fromEntries(STATUSES.map((s) => [s, 0]));
  for (const a of assets) {
    if (counts[a.status] !== undefined) counts[a.status] += 1;
  }
  return STATUSES.map((status) => ({ label: status, value: counts[status] }));
}

// Top N clients by asset count, remainder folded into "Other clients".
export function countByClient(assets, clients, topN = 6) {
  const counts = new Map();
  for (const a of assets) {
    counts.set(a.clientId, (counts.get(a.clientId) || 0) + 1);
  }
  const nameOf = (id) => clients.find((c) => c.id === id)?.name || 'Unknown client';
  const rows = [...counts.entries()]
    .map(([clientId, value]) => ({ label: nameOf(clientId), value }))
    .sort((a, b) => b.value - a.value);

  if (rows.length <= topN) return rows;
  const top = rows.slice(0, topN);
  const otherTotal = rows.slice(topN).reduce((sum, r) => sum + r.value, 0);
  return otherTotal > 0 ? [...top, { label: 'Other clients', value: otherTotal }] : top;
}

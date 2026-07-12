import { STATUSES } from '../constants';
import { EMPLOYEE_STATUSES } from '../employeeConstants';

export function assetStatusMatrix(assets, clients) {
  return clients.map((c) => {
    const row = { client: c.name };
    STATUSES.forEach((s) => { row[s] = 0; });
    assets.filter((a) => a.clientId === c.id).forEach((a) => {
      if (row[a.status] !== undefined) row[a.status] += 1;
    });
    return row;
  });
}

export function employeeStatusMatrix(employees, clients) {
  return clients.map((c) => {
    const row = { client: c.name };
    EMPLOYEE_STATUSES.forEach((s) => { row[s] = 0; });
    employees.filter((e) => e.clientId === c.id).forEach((e) => {
      if (row[e.status] !== undefined) row[e.status] += 1;
    });
    return row;
  });
}

export function ticketOpenClosedCounts(tickets) {
  const open = tickets.filter((t) => t.status !== 'Solved' && t.status !== 'Closed').length;
  return { open, closed: tickets.length - open };
}

export function dailyTaskCountsThisMonth(tasks) {
  const now = new Date();
  const prefix = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}`;
  const counts = new Map();
  tasks
    .filter((t) => (t.date || '').startsWith(prefix))
    .forEach((t) => {
      const name = t.createdByName || t.createdBy || 'Unknown';
      counts.set(name, (counts.get(name) || 0) + 1);
    });
  return [...counts.entries()]
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value);
}

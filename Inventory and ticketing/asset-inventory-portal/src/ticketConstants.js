export const TICKET_TYPES = ['Incident', 'Request'];

export const TICKET_STATUSES = ['New', 'Processing', 'Pending', 'Solved', 'Closed'];

export const TICKET_CATEGORIES = [
  'Hardware',
  'Software',
  'Network',
  'Account & Access',
  'Printer',
  'Other',
];

export const REQUEST_SOURCES = ['Portal', 'Email', 'Phone', 'Walk-in'];

export const URGENCY_LEVELS = ['Low', 'Medium', 'High'];
export const IMPACT_LEVELS = ['Low', 'Medium', 'High'];
export const PRIORITY_LEVELS = ['Low', 'Medium', 'High', 'Very High'];

// Priority is derived from urgency x impact, the same idea GLPI's ticketing
// engine uses — rows are impact, columns are urgency.
const PRIORITY_MATRIX = {
  Low: { Low: 'Low', Medium: 'Low', High: 'Medium' },
  Medium: { Low: 'Low', Medium: 'Medium', High: 'High' },
  High: { Low: 'Medium', Medium: 'High', High: 'Very High' },
};

export function computePriority(urgency, impact) {
  return PRIORITY_MATRIX[impact]?.[urgency] || 'Medium';
}

export const EMPTY_TICKET_FORM = {
  title: '',
  clientId: '',
  assetId: '',
  type: TICKET_TYPES[0],
  category: TICKET_CATEGORIES[0],
  description: '',
  urgency: 'Medium',
  impact: 'Medium',
  location: '',
  source: REQUEST_SOURCES[0],
  assignedTo: '',
  observers: '',
};

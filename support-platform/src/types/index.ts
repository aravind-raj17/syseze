export type TicketStatus =
  | 'pending_payment'
  | 'paid'
  | 'queued'
  | 'assigned'
  | 'in_session'
  | 'awaiting_confirmation'
  | 'resolved'
  | 'cancelled'
  | 'expired';

export interface Ticket {
  id: string;
  ticketNumber: string;
  customerName: string;
  customerEmail: string;
  customerPhone?: string;
  issueCategory: string;
  issueDescription: string;
  hoursPurchased: number;
  amountPaid: number;
  status: TicketStatus;
  agentId?: string;
  agent?: { id: string; name: string; email: string };
  sessionStartedAt?: string;
  sessionEndedAt?: string;
  resolvedAt?: string;
  customerConfirmedAt?: string;
  sessionNotes?: string;
  createdAt: string;
  messages?: Message[];
  payment?: Payment;
}

export interface Message {
  id: string;
  ticketId: string;
  senderType: 'customer' | 'agent';
  content: string;
  createdAt: string;
}

export interface Payment {
  id: string;
  ticketId: string;
  amount: number;
  provider: string;
  status: string;
  transactionRef?: string;
  createdAt: string;
}

export const PRICE_PER_HOUR = 49;
export const HOURS_OPTIONS = [1, 2, 3, 4, 6, 8];
export const ISSUE_CATEGORIES = [
  'Windows',
  'macOS',
  'Linux',
  'Networking',
  'Software Install',
  'Virus/Malware',
  'Email/Office',
  'Other',
];

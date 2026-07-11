import {
  addDoc,
  collection,
  doc,
  onSnapshot,
  orderBy,
  query,
  serverTimestamp,
  updateDoc,
  where,
} from 'firebase/firestore';
import { db } from '../firebase';
import { computePriority } from '../ticketConstants';

// --- Tickets -------------------------------------------------------------

export function subscribeTickets(onData) {
  const q = query(collection(db, 'tickets'), orderBy('createdAt', 'desc'));
  return onSnapshot(q, (snap) => {
    onData(snap.docs.map((d) => ({ id: d.id, ...d.data() })));
  });
}

export function subscribeTicket(ticketId, onData) {
  return onSnapshot(doc(db, 'tickets', ticketId), (snap) => {
    onData(snap.exists() ? { id: snap.id, ...snap.data() } : null);
  });
}

export async function createTicket(values, createdBy) {
  const priority = computePriority(values.urgency, values.impact);
  const observers = values.observers
    .split(',')
    .map((s) => s.trim())
    .filter(Boolean);

  const ref_ = await addDoc(collection(db, 'tickets'), {
    title: values.title,
    clientId: values.clientId,
    assetId: values.assetId || null,
    type: values.type,
    category: values.category,
    description: values.description,
    status: 'New',
    urgency: values.urgency,
    impact: values.impact,
    priority,
    location: values.location,
    source: values.source,
    requester: createdBy,
    observers,
    assignedTo: values.assignedTo || '',
    createdBy,
    createdAt: serverTimestamp(),
    updatedAt: serverTimestamp(),
    solvedAt: null,
    closedAt: null,
  });
  return ref_.id;
}

// `changes` should already include a recomputed `priority` if urgency or
// impact changed — the caller has the full current ticket state, this
// function doesn't, so it just applies whatever patch it's given.
export async function updateTicketFields(ticketId, changes, changedBy) {
  await updateDoc(doc(db, 'tickets', ticketId), { ...changes, updatedAt: serverTimestamp() });
  await addComment(ticketId, {
    type: 'system',
    content: `Ticket updated by ${changedBy}.`,
    authorEmail: changedBy,
  });
}

export async function updateTicketStatus(ticketId, newStatus, changedBy) {
  const patch = { status: newStatus, updatedAt: serverTimestamp() };
  if (newStatus === 'Solved') patch.solvedAt = serverTimestamp();
  if (newStatus === 'Closed') patch.closedAt = serverTimestamp();
  if (newStatus !== 'Solved' && newStatus !== 'Closed') {
    patch.solvedAt = null;
    patch.closedAt = null;
  }
  await updateDoc(doc(db, 'tickets', ticketId), patch);
  await addComment(ticketId, {
    type: 'system',
    content: `Status changed to ${newStatus} by ${changedBy}.`,
    authorEmail: changedBy,
  });
}

// --- Comments / timeline ---------------------------------------------------

export function subscribeTicketComments(ticketId, onData) {
  // Equality filter + orderBy on a different field needs a composite index
  // in Firestore, so we sort client-side instead (same approach as assets).
  const q = query(collection(db, 'ticketComments'), where('ticketId', '==', ticketId));
  return onSnapshot(q, (snap) => {
    const comments = snap.docs.map((d) => ({ id: d.id, ...d.data() }));
    comments.sort((a, b) => (a.createdAt?.toMillis?.() ?? 0) - (b.createdAt?.toMillis?.() ?? 0));
    onData(comments);
  });
}

export async function addComment(ticketId, { type = 'followup', content, authorEmail }) {
  await addDoc(collection(db, 'ticketComments'), {
    ticketId,
    type,
    content,
    authorEmail,
    createdAt: serverTimestamp(),
  });
  await updateDoc(doc(db, 'tickets', ticketId), { updatedAt: serverTimestamp() });
}

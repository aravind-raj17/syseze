import {
  addDoc,
  collection,
  doc,
  onSnapshot,
  query,
  serverTimestamp,
  updateDoc,
  where,
} from 'firebase/firestore';
import { db } from '../firebase';

export function subscribeClientEmployees(clientId, onData) {
  const q = query(collection(db, 'employees'), where('clientId', '==', clientId));
  return onSnapshot(q, (snap) => {
    const employees = snap.docs.map((d) => ({ id: d.id, ...d.data() }));
    employees.sort((a, b) => a.name.localeCompare(b.name));
    onData(employees);
  });
}

export async function createEmployee(clientId, organizationName, values, changedBy) {
  const ref = await addDoc(collection(db, 'employees'), {
    clientId,
    organizationName,
    name: values.name,
    email: values.email,
    licenseAssigned: values.licenseAssigned,
    status: values.status,
    createdAt: serverTimestamp(),
    updatedAt: serverTimestamp(),
  });
  await logActivity({ clientId, action: 'employee_created', changedBy, changes: values });
  return ref.id;
}

export async function updateEmployee(id, clientId, before, values, changedBy) {
  await updateDoc(doc(db, 'employees', id), { ...values, updatedAt: serverTimestamp() });
  await logActivity({ clientId, action: 'employee_updated', changedBy, changes: diffFields(before, values) });
}

function diffFields(before, after) {
  const changes = {};
  for (const key of Object.keys(after)) {
    if ((before[key] ?? '') !== (after[key] ?? '')) {
      changes[key] = { before: before[key] ?? null, after: after[key] ?? null };
    }
  }
  return changes;
}

// Reuses the same activityLog collection as assets — assetId is null for
// employee entries so the two stay distinguishable in a shared feed.
async function logActivity({ clientId, action, changedBy, changes }) {
  await addDoc(collection(db, 'activityLog'), {
    assetId: null,
    clientId,
    action,
    changedBy,
    changes,
    timestamp: serverTimestamp(),
  });
}

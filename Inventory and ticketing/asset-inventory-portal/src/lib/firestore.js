import {
  addDoc,
  collection,
  doc,
  getCountFromServer,
  onSnapshot,
  orderBy,
  query,
  serverTimestamp,
  updateDoc,
  where,
} from 'firebase/firestore';
import { db } from '../firebase';

// --- Clients ---------------------------------------------------------

export function subscribeClients(onData) {
  const q = query(collection(db, 'clients'), orderBy('name'));
  return onSnapshot(q, (snap) => {
    onData(snap.docs.map((d) => ({ id: d.id, ...d.data() })));
  });
}

export async function createClient(data) {
  await addDoc(collection(db, 'clients'), {
    ...data,
    active: true,
    createdAt: serverTimestamp(),
  });
}

export async function updateClient(id, data) {
  await updateDoc(doc(db, 'clients', id), data);
}

export async function setClientActive(id, active) {
  await updateDoc(doc(db, 'clients', id), { active });
}

export async function getClientAssetCount(clientId) {
  const q = query(collection(db, 'assets'), where('clientId', '==', clientId));
  const snap = await getCountFromServer(q);
  return snap.data().count;
}

// --- Assets ------------------------------------------------------------

export function subscribeClientAssets(clientId, onData) {
  const q = query(collection(db, 'assets'), where('clientId', '==', clientId));
  return onSnapshot(q, (snap) => {
    onData(snap.docs.map((d) => ({ id: d.id, ...d.data() })));
  });
}

export async function createAsset(data, changedBy) {
  const ref = await addDoc(collection(db, 'assets'), {
    ...data,
    addedBy: changedBy,
    createdAt: serverTimestamp(),
    updatedAt: serverTimestamp(),
  });
  await logActivity({ assetId: ref.id, clientId: data.clientId, action: 'created', changedBy, changes: data });
  return ref.id;
}

export async function updateAsset(id, before, values, changedBy) {
  await updateDoc(doc(db, 'assets', id), { ...values, updatedAt: serverTimestamp() });
  await logActivity({ assetId: id, clientId: values.clientId, action: 'updated', changedBy, changes: diffFields(before, values) });
}

export async function retireAsset(asset, changedBy) {
  await updateDoc(doc(db, 'assets', asset.id), { status: 'Retired', updatedAt: serverTimestamp() });
  await logActivity({
    assetId: asset.id,
    clientId: asset.clientId,
    action: 'deleted',
    changedBy,
    changes: { status: { before: asset.status, after: 'Retired' } },
  });
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

// --- Activity log --------------------------------------------------------

async function logActivity({ assetId, clientId, action, changedBy, changes }) {
  await addDoc(collection(db, 'activityLog'), {
    assetId,
    clientId,
    action,
    changedBy,
    changes,
    timestamp: serverTimestamp(),
  });
}

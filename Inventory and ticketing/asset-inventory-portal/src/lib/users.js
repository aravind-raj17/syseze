import { initializeApp, deleteApp } from 'firebase/app';
import { createUserWithEmailAndPassword, getAuth, signOut as secondarySignOut } from 'firebase/auth';
import { collection, doc, getDoc, getFirestore, onSnapshot, serverTimestamp, setDoc } from 'firebase/firestore';
import { db, firebaseConfig } from '../firebase';

export function subscribeUserDoc(uid, onData) {
  return onSnapshot(doc(db, 'users', uid), (snap) => {
    onData(snap.exists() ? { id: snap.id, ...snap.data() } : null);
  });
}

export function subscribeUsers(onData) {
  return onSnapshot(collection(db, 'users'), (snap) => {
    const users = snap.docs.map((d) => ({ id: d.id, ...d.data() }));
    users.sort((a, b) => (a.name || a.email || '').localeCompare(b.name || b.email || ''));
    onData(users);
  });
}

// First-login self-heal: if a signed-in account has no users/{uid} doc yet
// (an account that predates this feature, or wasn't provisioned through the
// Admin User Management page), create one. Defaults to admin — safe here
// because this app has no public sign-up; every Firebase Auth account was
// already manually provisioned by someone trusted. Once an admin starts
// creating staff through the Admin User Management page, their role docs
// exist before they ever log in, so this path only fires for pre-existing
// or console-created accounts.
export async function ensureUserDoc(firebaseUser) {
  const ref = doc(db, 'users', firebaseUser.uid);
  const snap = await getDoc(ref);
  if (snap.exists()) return { id: snap.id, ...snap.data() };

  const data = {
    name: firebaseUser.displayName || firebaseUser.email,
    email: firebaseUser.email,
    role: 'admin',
    createdAt: serverTimestamp(),
    createdBy: 'self-bootstrap',
  };
  await setDoc(ref, data);
  return { id: firebaseUser.uid, ...data };
}

// Creating a user with the client Auth SDK signs that new user in on
// whatever app instance made the call. To avoid signing the acting admin
// out of their own session, we spin up a throwaway secondary Firebase app
// (same config, different name) purely for the create-user call, then tear
// it down — the primary `auth` the admin is using never sees this happen.
export async function createUserWithRole(values, createdByEmail) {
  const secondaryApp = initializeApp(firebaseConfig, `user-creation-${Date.now()}`);
  const secondaryAuth = getAuth(secondaryApp);
  const secondaryDb = getFirestore(secondaryApp);

  try {
    const credential = await createUserWithEmailAndPassword(secondaryAuth, values.email, values.password);
    const uid = credential.user.uid;

    // Written via the secondary app's Firestore client (still authenticated
    // as the brand-new user at this point), matching the rule's self-create
    // clause — avoids any race with the admin's own primary session.
    await setDoc(doc(secondaryDb, 'users', uid), {
      name: values.name,
      email: values.email,
      role: values.role,
      createdAt: serverTimestamp(),
      createdBy: createdByEmail,
    });

    return uid;
  } finally {
    await secondarySignOut(secondaryAuth).catch(() => {});
    await deleteApp(secondaryApp).catch(() => {});
  }
}

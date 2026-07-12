import { initializeApp, deleteApp } from 'firebase/app';
import { createUserWithEmailAndPassword, getAuth, sendPasswordResetEmail, signOut as secondarySignOut } from 'firebase/auth';
import { collection, doc, getDoc, getDocs, getFirestore, limit, onSnapshot, query, serverTimestamp, setDoc, updateDoc } from 'firebase/firestore';
import { auth, db, firebaseConfig } from '../firebase';

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

// First-login self-heal: if a signed-in account has no users/{uid} doc yet,
// create one. Only defaults to admin on a genuine cold start — i.e. the
// users collection is completely empty, meaning this is the very first
// person to ever log in and there is no other way to bootstrap an admin.
// Once at least one users doc exists, any further unprovisioned account
// (e.g. one created directly in the Firebase console instead of through
// Admin User Management, by mistake) defaults to standard instead of
// silently inheriting admin — that mistake should require an actual admin
// to fix via User Management, not grant full access on its own.
export async function ensureUserDoc(firebaseUser) {
  const ref = doc(db, 'users', firebaseUser.uid);
  const snap = await getDoc(ref);
  if (snap.exists()) return { id: snap.id, ...snap.data() };

  const existingUsers = await getDocs(query(collection(db, 'users'), limit(1)));
  const role = existingUsers.empty ? 'admin' : 'standard';

  const data = {
    name: firebaseUser.displayName || firebaseUser.email,
    email: firebaseUser.email,
    role,
    active: true,
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
      active: true,
      createdAt: serverTimestamp(),
      createdBy: createdByEmail,
    });

    return uid;
  } finally {
    await secondarySignOut(secondaryAuth).catch(() => {});
    await deleteApp(secondaryApp).catch(() => {});
  }
}

// There's no Admin SDK here (client-only app, no backend), so a client
// can never delete *another* user's Firebase Auth credential — only a
// user can delete themselves. "Delete" is therefore implemented as
// deactivation, the same soft-delete pattern already used for Clients/
// Assets/Employees: flips active:false on their Firestore role doc, which
// AuthContext watches in real time and force-signs them out on — including
// mid-session, not just on next login.
export async function setUserActive(uid, active) {
  await updateDoc(doc(db, 'users', uid), { active });
}

export async function sendPasswordReset(email) {
  await sendPasswordResetEmail(auth, email);
}

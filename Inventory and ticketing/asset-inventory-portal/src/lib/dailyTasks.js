import { addDoc, collection, deleteDoc, doc, onSnapshot, query, serverTimestamp, where } from 'firebase/firestore';
import { db } from '../firebase';

// Admins can list the whole collection unfiltered (the Firestore rule's
// isAdmin() branch doesn't depend on document data, so it's provable for
// any query). Standard users MUST filter by their own email in the query
// itself — Firestore can't silently drop non-matching docs from a list
// request, an unscoped query would just fail permission-denied outright.
export function subscribeDailyTasks({ isAdmin, email }, onData) {
  const q = isAdmin
    ? collection(db, 'dailyTasks')
    : query(collection(db, 'dailyTasks'), where('createdBy', '==', email));

  return onSnapshot(q, (snap) => {
    const tasks = snap.docs.map((d) => ({ id: d.id, ...d.data() }));
    tasks.sort((a, b) => {
      const dateDiff = (b.date || '').localeCompare(a.date || '');
      if (dateDiff !== 0) return dateDiff;
      return (b.createdAt?.toMillis?.() ?? 0) - (a.createdAt?.toMillis?.() ?? 0);
    });
    onData(tasks);
  });
}

export async function createDailyTask(values, currentUser) {
  await addDoc(collection(db, 'dailyTasks'), {
    clientId: values.clientId,
    clientName: values.clientName,
    issuesAttended: values.issuesAttended,
    loginTime: values.loginTime,
    logoutTime: values.logoutTime,
    createdBy: currentUser.email,
    createdByName: currentUser.displayName || currentUser.email,
    date: new Date().toISOString().slice(0, 10),
    createdAt: serverTimestamp(),
  });
}

// Admin-only per firestore.rules (allow delete: if isAdmin()) — this is a
// genuine hard delete, unlike the soft-delete convention used for Clients/
// Assets/Employees, since a daily task entry isn't a record anything else
// references.
export async function deleteDailyTask(id) {
  await deleteDoc(doc(db, 'dailyTasks', id));
}

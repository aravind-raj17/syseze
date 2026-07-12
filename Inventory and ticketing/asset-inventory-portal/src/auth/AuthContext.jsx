import { createContext, useContext, useEffect, useState } from 'react';
import { onAuthStateChanged, signInWithEmailAndPassword, signOut } from 'firebase/auth';
import { auth } from '../firebase';
import { ensureUserDoc, subscribeUserDoc } from '../lib/users';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [currentUser, setCurrentUser] = useState(null);
  const [userDoc, setUserDoc] = useState(null);
  const [loading, setLoading] = useState(true);
  const [deactivatedNotice, setDeactivatedNotice] = useState(false);

  useEffect(() => {
    const unsubscribeAuth = onAuthStateChanged(auth, (user) => {
      setCurrentUser(user);
      if (!user) {
        setUserDoc(null);
        setLoading(false);
      }
    });
    return unsubscribeAuth;
  }, []);

  useEffect(() => {
    if (!currentUser) return undefined;

    let unsubscribeDoc;
    let cancelled = false;

    ensureUserDoc(currentUser).then(() => {
      if (cancelled) return;
      unsubscribeDoc = subscribeUserDoc(currentUser.uid, (data) => {
        // Deactivating a user (User Management's "Deactivate", the
        // delete-equivalent for staff logins) takes effect immediately —
        // this listener fires mid-session too, not just on next login.
        if (data && data.active === false) {
          setDeactivatedNotice(true);
          signOut(auth);
          return;
        }
        setUserDoc(data);
        setLoading(false);
      });
    });

    return () => {
      cancelled = true;
      if (unsubscribeDoc) unsubscribeDoc();
    };
  }, [currentUser]);

  const login = async (email, password) => {
    setDeactivatedNotice(false);
    return signInWithEmailAndPassword(auth, email, password);
  };
  const logout = () => signOut(auth);
  const clearDeactivatedNotice = () => setDeactivatedNotice(false);

  // Fails closed: by the time `loading` is false, ensureUserDoc has always
  // resolved a real role doc, so this fallback is only a defensive backstop
  // (e.g. userDoc briefly null) and should never grant admin by default.
  const role = userDoc?.role || 'standard';
  const isAdmin = role === 'admin';

  return (
    <AuthContext.Provider
      value={{ currentUser, userDoc, role, isAdmin, loading, login, logout, deactivatedNotice, clearDeactivatedNotice }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  return useContext(AuthContext);
}

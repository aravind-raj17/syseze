import { createContext, useContext, useEffect, useState } from 'react';
import { onAuthStateChanged, signInWithEmailAndPassword, signOut } from 'firebase/auth';
import { auth } from '../firebase';
import { ensureUserDoc, subscribeUserDoc } from '../lib/users';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [currentUser, setCurrentUser] = useState(null);
  const [userDoc, setUserDoc] = useState(null);
  const [loading, setLoading] = useState(true);

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
        setUserDoc(data);
        setLoading(false);
      });
    });

    return () => {
      cancelled = true;
      if (unsubscribeDoc) unsubscribeDoc();
    };
  }, [currentUser]);

  const login = (email, password) => signInWithEmailAndPassword(auth, email, password);
  const logout = () => signOut(auth);

  const role = userDoc?.role || 'admin';
  const isAdmin = role === 'admin';

  return (
    <AuthContext.Provider value={{ currentUser, userDoc, role, isAdmin, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  return useContext(AuthContext);
}

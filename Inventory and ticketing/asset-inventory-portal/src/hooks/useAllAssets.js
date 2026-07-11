import { useEffect, useState } from 'react';
import { collection, onSnapshot } from 'firebase/firestore';
import { db } from '../firebase';

// Dashboard-wide aggregation needs every asset across every client. Fine at
// this tool's scale (an internal MSP tracker, not a multi-tenant SaaS) —
// well within the Firestore free-tier read budget.
export function useAllAssets() {
  const [assets, setAssets] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribe = onSnapshot(collection(db, 'assets'), (snap) => {
      setAssets(snap.docs.map((d) => ({ id: d.id, ...d.data() })));
      setLoading(false);
    });
    return unsubscribe;
  }, []);

  return { assets, loading };
}

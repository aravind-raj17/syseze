import { useEffect, useState } from 'react';
import { subscribeClientAssets } from '../lib/firestore';

export function useClientAssets(clientId) {
  const [assets, setAssets] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!clientId) {
      setAssets([]);
      setLoading(false);
      return undefined;
    }
    setLoading(true);
    const unsubscribe = subscribeClientAssets(clientId, (data) => {
      setAssets(data);
      setLoading(false);
    });
    return unsubscribe;
  }, [clientId]);

  return { assets, loading };
}

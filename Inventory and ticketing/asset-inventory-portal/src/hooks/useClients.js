import { useEffect, useState } from 'react';
import { subscribeClients } from '../lib/firestore';

export function useClients() {
  const [clients, setClients] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribe = subscribeClients((data) => {
      setClients(data);
      setLoading(false);
    });
    return unsubscribe;
  }, []);

  return { clients, loading };
}

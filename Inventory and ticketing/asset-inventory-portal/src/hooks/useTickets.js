import { useEffect, useState } from 'react';
import { subscribeTickets } from '../lib/tickets';

export function useTickets() {
  const [tickets, setTickets] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribe = subscribeTickets((data) => {
      setTickets(data);
      setLoading(false);
    });
    return unsubscribe;
  }, []);

  return { tickets, loading };
}

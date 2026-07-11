import { useEffect, useState } from 'react';
import { subscribeTicket } from '../lib/tickets';

export function useTicket(ticketId) {
  const [ticket, setTicket] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!ticketId) {
      setTicket(null);
      setLoading(false);
      return undefined;
    }
    setLoading(true);
    const unsubscribe = subscribeTicket(ticketId, (data) => {
      setTicket(data);
      setLoading(false);
    });
    return unsubscribe;
  }, [ticketId]);

  return { ticket, loading };
}

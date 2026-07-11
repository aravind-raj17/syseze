import { useEffect, useState } from 'react';
import { subscribeTicketComments } from '../lib/tickets';

export function useTicketComments(ticketId) {
  const [comments, setComments] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!ticketId) {
      setComments([]);
      setLoading(false);
      return undefined;
    }
    setLoading(true);
    const unsubscribe = subscribeTicketComments(ticketId, (data) => {
      setComments(data);
      setLoading(false);
    });
    return unsubscribe;
  }, [ticketId]);

  return { comments, loading };
}

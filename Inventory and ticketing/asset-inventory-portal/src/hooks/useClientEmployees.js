import { useEffect, useState } from 'react';
import { subscribeClientEmployees } from '../lib/employees';

export function useClientEmployees(clientId) {
  const [employees, setEmployees] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!clientId) {
      setEmployees([]);
      setLoading(false);
      return undefined;
    }
    setLoading(true);
    const unsubscribe = subscribeClientEmployees(clientId, (data) => {
      setEmployees(data);
      setLoading(false);
    });
    return unsubscribe;
  }, [clientId]);

  return { employees, loading };
}

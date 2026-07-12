import { useEffect, useState } from 'react';
import { subscribeUsers } from '../lib/users';

export function useUsers() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribe = subscribeUsers((data) => {
      setUsers(data);
      setLoading(false);
    });
    return unsubscribe;
  }, []);

  return { users, loading };
}

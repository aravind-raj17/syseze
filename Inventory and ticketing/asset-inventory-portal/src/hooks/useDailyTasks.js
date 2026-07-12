import { useEffect, useState } from 'react';
import { subscribeDailyTasks } from '../lib/dailyTasks';

export function useDailyTasks(isAdmin, email) {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!email) return undefined;
    setLoading(true);
    const unsubscribe = subscribeDailyTasks({ isAdmin, email }, (data) => {
      setTasks(data);
      setLoading(false);
    });
    return unsubscribe;
  }, [isAdmin, email]);

  return { tasks, loading };
}

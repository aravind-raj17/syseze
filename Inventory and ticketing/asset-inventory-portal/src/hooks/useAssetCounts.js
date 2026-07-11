import { useEffect, useState } from 'react';
import { getClientAssetCount } from '../lib/firestore';

export function useAssetCounts(clientIds) {
  const [counts, setCounts] = useState({});
  const key = clientIds.join(',');

  useEffect(() => {
    if (!key) {
      setCounts({});
      return undefined;
    }
    let cancelled = false;
    Promise.all(clientIds.map(async (id) => [id, await getClientAssetCount(id)])).then((pairs) => {
      if (!cancelled) setCounts(Object.fromEntries(pairs));
    });
    return () => {
      cancelled = true;
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [key]);

  return counts;
}

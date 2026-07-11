import { useMemo, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { useClients } from '../hooks/useClients';
import { useClientAssets } from '../hooks/useClientAssets';
import { createAsset, updateAsset, retireAsset } from '../lib/firestore';
import { exportAssetsCSV, exportAssetsXLSX, exportAssetsPDF } from '../lib/assetExport';
import { useAuth } from '../auth/AuthContext';
import { CATEGORIES, STATUSES, PAGE_SIZE, EMPTY_ASSET_FORM } from '../constants';
import StatusBadge from '../components/StatusBadge';
import AssetFormSlideOver from '../components/AssetFormSlideOver';
import ConfirmDialog from '../components/ConfirmDialog';
import BulkUploadDialog from '../components/BulkUploadDialog';
import ExportMenu from '../components/ExportMenu';
import ClientSubNav from '../components/ClientSubNav';

const COLUMNS = [
  ['assetTag', 'Asset Tag'],
  ['category', 'Category'],
  ['brand', 'Brand / Model'],
  ['serialNumber', 'Serial No.'],
  ['status', 'Status'],
  ['location', 'Location'],
  ['assignedTo', 'Assigned To'],
];

export default function ClientAssets() {
  const { clientId } = useParams();
  const navigate = useNavigate();
  const { currentUser } = useAuth();
  const { clients } = useClients();
  const { assets, loading } = useClientAssets(clientId);

  const [search, setSearch] = useState('');
  const [categoryFilter, setCategoryFilter] = useState('All');
  const [statusFilter, setStatusFilter] = useState('All');
  const [sortCol, setSortCol] = useState('assetTag');
  const [sortDir, setSortDir] = useState('asc');
  const [page, setPage] = useState(1);

  const [formOpen, setFormOpen] = useState(false);
  const [editingAsset, setEditingAsset] = useState(null);
  const [retireTarget, setRetireTarget] = useState(null);
  const [saving, setSaving] = useState(false);
  const [bulkOpen, setBulkOpen] = useState(false);
  const [importNotice, setImportNotice] = useState('');

  const client = clients.find((c) => c.id === clientId);

  const sortBy = (col) => {
    if (sortCol === col) {
      setSortDir((d) => (d === 'asc' ? 'desc' : 'asc'));
    } else {
      setSortCol(col);
      setSortDir('asc');
    }
    setPage(1);
  };

  const filteredSorted = useMemo(() => {
    const q = search.trim().toLowerCase();
    let list = assets;
    if (q) {
      list = list.filter(
        (a) =>
          a.assetTag.toLowerCase().includes(q) ||
          (a.brand || '').toLowerCase().includes(q) ||
          (a.model || '').toLowerCase().includes(q) ||
          (a.serialNumber || '').toLowerCase().includes(q) ||
          (a.assignedTo || '').toLowerCase().includes(q)
      );
    }
    if (categoryFilter !== 'All') list = list.filter((a) => a.category === categoryFilter);
    if (statusFilter !== 'All') list = list.filter((a) => a.status === statusFilter);

    const dir = sortDir === 'asc' ? 1 : -1;
    return [...list].sort((a, b) => {
      const va = (a[sortCol] || '').toString().toLowerCase();
      const vb = (b[sortCol] || '').toString().toLowerCase();
      if (va < vb) return -1 * dir;
      if (va > vb) return 1 * dir;
      return 0;
    });
  }, [assets, search, categoryFilter, statusFilter, sortCol, sortDir]);

  const totalPages = Math.max(1, Math.ceil(filteredSorted.length / PAGE_SIZE));
  const pageItems = filteredSorted.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

  const openNewAsset = () => {
    setEditingAsset(null);
    setFormOpen(true);
  };
  const openEditAsset = (asset) => {
    setEditingAsset(asset);
    setFormOpen(true);
  };

  const handleSaveAsset = async (values) => {
    setSaving(true);
    try {
      if (editingAsset) {
        await updateAsset(editingAsset.id, editingAsset, values, currentUser.email);
      } else {
        await createAsset(values, currentUser.email);
      }
      setFormOpen(false);
    } finally {
      setSaving(false);
    }
  };

  const handleRetireConfirm = async () => {
    await retireAsset(retireTarget, currentUser.email);
    setRetireTarget(null);
  };

  const handleImported = (count) => {
    setImportNotice(`Imported ${count} asset${count === 1 ? '' : 's'}.`);
    setTimeout(() => setImportNotice(''), 5000);
  };

  const arrow = (col) => (sortCol === col ? (sortDir === 'asc' ? ' ▲' : ' ▼') : '');
  const exportFilenameBase = client ? `${client.code}-assets` : 'assets';

  return (
    <div className="mx-auto flex max-w-[1200px] flex-col gap-4 p-6">
      <div className="flex items-start gap-3">
        <button
          type="button"
          onClick={() => navigate('/dashboard')}
          className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          ← Back
        </button>
        <div className="flex-1">
          <div className="flex items-center gap-2">
            <h1 className="text-xl font-semibold text-slate-900 dark:text-white">{client?.name || '…'}</h1>
            {client && (
              <span className="rounded-full border border-slate-300 px-2 py-0.5 text-xs font-medium text-slate-500 dark:border-slate-700 dark:text-slate-400">
                {client.code}
              </span>
            )}
          </div>
          <p className="text-sm text-slate-500 dark:text-slate-400">
            {client?.contactPerson} · {client?.contactEmail}
          </p>
          <div className="mt-2">
            <ClientSubNav clientId={clientId} active="assets" />
          </div>
        </div>
        <ExportMenu
          disabled={filteredSorted.length === 0}
          options={[
            { label: 'CSV', onSelect: () => exportAssetsCSV(filteredSorted, exportFilenameBase) },
            { label: 'Excel (.xlsx)', onSelect: () => exportAssetsXLSX(filteredSorted, exportFilenameBase) },
            { label: 'PDF', onSelect: () => exportAssetsPDF(filteredSorted, exportFilenameBase, client?.name) },
          ]}
        />
        <button
          type="button"
          onClick={() => setBulkOpen(true)}
          className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          Bulk upload
        </button>
        <button
          type="button"
          onClick={openNewAsset}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          + Add asset
        </button>
      </div>

      {importNotice && (
        <p className="rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
          {importNotice}
        </p>
      )}

      <div className="flex flex-wrap gap-3">
        <input
          type="search"
          placeholder="Search tag, brand, serial, assignee…"
          value={search}
          onChange={(e) => {
            setSearch(e.target.value);
            setPage(1);
          }}
          className="input min-w-[220px] flex-1"
        />
        <select
          className="input w-auto min-w-[170px]"
          value={categoryFilter}
          onChange={(e) => {
            setCategoryFilter(e.target.value);
            setPage(1);
          }}
        >
          <option value="All">All categories</option>
          {CATEGORIES.map((cat) => <option key={cat} value={cat}>{cat}</option>)}
        </select>
        <select
          className="input w-auto min-w-[150px]"
          value={statusFilter}
          onChange={(e) => {
            setStatusFilter(e.target.value);
            setPage(1);
          }}
        >
          <option value="All">All statuses</option>
          {STATUSES.map((st) => <option key={st} value={st}>{st}</option>)}
        </select>
      </div>

      {loading ? (
        <p className="text-sm text-slate-500 dark:text-slate-400">Loading assets…</p>
      ) : (
        <div className="overflow-x-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
          <table className="w-full text-left text-sm">
            <thead className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:text-slate-400">
              <tr>
                {COLUMNS.map(([col, label]) => (
                  <th key={col} className="cursor-pointer select-none px-4 py-3" onClick={() => sortBy(col)}>
                    {label}{arrow(col)}
                  </th>
                ))}
                <th className="px-4 py-3" />
              </tr>
            </thead>
            <tbody>
              {pageItems.map((a) => (
                <tr key={a.id} className="border-b border-slate-100 last:border-0 dark:border-slate-800">
                  <td className="px-4 py-3 font-mono text-[13px] dark:text-slate-200">{a.assetTag}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{a.category}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{[a.brand, a.model].filter(Boolean).join(' ') || '—'}</td>
                  <td className="px-4 py-3 text-slate-500 dark:text-slate-400">{a.serialNumber || '—'}</td>
                  <td className="px-4 py-3"><StatusBadge status={a.status} /></td>
                  <td className="px-4 py-3 dark:text-slate-200">{a.location || '—'}</td>
                  <td className="px-4 py-3 dark:text-slate-200">{a.assignedTo || '—'}</td>
                  <td className="px-4 py-3">
                    <div className="flex justify-end gap-2">
                      <button
                        type="button"
                        onClick={() => openEditAsset(a)}
                        className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                      >
                        Edit
                      </button>
                      {a.status !== 'Retired' && (
                        <button
                          type="button"
                          onClick={() => setRetireTarget(a)}
                          className="rounded-lg border border-slate-300 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                          Retire
                        </button>
                      )}
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {!loading && pageItems.length === 0 && (
        <p className="text-sm text-slate-500 dark:text-slate-400">No assets match the current search and filters.</p>
      )}

      {!loading && totalPages > 1 && (
        <div className="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
          <span>Page {page} of {totalPages}</span>
          <div className="flex gap-2">
            <button
              type="button"
              disabled={page === 1}
              onClick={() => setPage((p) => p - 1)}
              className="rounded-lg border border-slate-300 px-3 py-1.5 font-medium disabled:opacity-40 dark:border-slate-700"
            >
              Previous
            </button>
            <button
              type="button"
              disabled={page === totalPages}
              onClick={() => setPage((p) => p + 1)}
              className="rounded-lg border border-slate-300 px-3 py-1.5 font-medium disabled:opacity-40 dark:border-slate-700"
            >
              Next
            </button>
          </div>
        </div>
      )}

      <AssetFormSlideOver
        open={formOpen}
        title={editingAsset ? 'Edit asset' : 'Add asset'}
        initialValues={editingAsset || { ...EMPTY_ASSET_FORM, clientId }}
        clients={clients}
        saving={saving}
        onSave={handleSaveAsset}
        onClose={() => setFormOpen(false)}
      />

      <ConfirmDialog
        open={!!retireTarget}
        title="Retire this asset?"
        body={
          retireTarget
            ? `"${retireTarget.assetTag}" will be marked Retired and kept in the record for the activity log — this isn't a hard delete.`
            : ''
        }
        confirmLabel="Retire asset"
        onConfirm={handleRetireConfirm}
        onCancel={() => setRetireTarget(null)}
      />

      <BulkUploadDialog
        open={bulkOpen}
        clientId={clientId}
        changedBy={currentUser.email}
        onClose={() => setBulkOpen(false)}
        onImported={handleImported}
      />
    </div>
  );
}

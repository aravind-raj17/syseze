import { useRef, useState } from 'react';
import { parseAssetImportCSV } from '../lib/assetImport';
import { downloadAssetTemplate } from '../lib/assetExport';
import { createAsset } from '../lib/firestore';

export default function BulkUploadDialog({ open, clientId, changedBy, onClose, onImported }) {
  const fileInputRef = useRef(null);
  const [fileName, setFileName] = useState('');
  const [parsed, setParsed] = useState(null); // { valid, errors }
  const [importing, setImporting] = useState(false);
  const [importError, setImportError] = useState('');

  if (!open) return null;

  const reset = () => {
    setFileName('');
    setParsed(null);
    setImportError('');
    if (fileInputRef.current) fileInputRef.current.value = '';
  };

  const handleClose = () => {
    reset();
    onClose();
  };

  const handleFile = async (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    setFileName(file.name);
    setImportError('');
    const text = await file.text();
    setParsed(parseAssetImportCSV(text, clientId));
  };

  const handleImport = async () => {
    if (!parsed || parsed.valid.length === 0) return;
    setImporting(true);
    setImportError('');
    try {
      for (const asset of parsed.valid) {
        await createAsset(asset, changedBy);
      }
      onImported(parsed.valid.length);
      reset();
      onClose();
    } catch {
      setImportError('Something went wrong importing assets. No further rows were created — check the ones already saved before retrying.');
    } finally {
      setImporting(false);
    }
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" onClick={handleClose}>
      <div
        role="dialog"
        aria-modal="true"
        className="flex max-h-[85vh] w-full max-w-[560px] flex-col gap-4 overflow-y-auto rounded-xl bg-white p-6 shadow-lg dark:bg-slate-900"
        onClick={(e) => e.stopPropagation()}
      >
        <div>
          <h3 className="text-base font-semibold text-slate-900 dark:text-white">Bulk upload assets</h3>
          <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Upload a CSV in the template format to add multiple assets to this client at once.
          </p>
        </div>

        <button
          type="button"
          onClick={downloadAssetTemplate}
          className="self-start rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
        >
          Download CSV template
        </button>

        <label className="flex flex-col gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
          CSV file
          <input
            ref={fileInputRef}
            type="file"
            accept=".csv,text/csv"
            onChange={handleFile}
            className="text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-white hover:file:bg-blue-700 dark:text-slate-400"
          />
        </label>

        {parsed && (
          <div className="flex flex-col gap-2 rounded-lg border border-slate-200 p-3 text-sm dark:border-slate-700">
            <p className="text-slate-700 dark:text-slate-300">
              <span className="font-medium text-green-700 dark:text-green-400">{parsed.valid.length} ready to import</span>
              {parsed.errors.length > 0 && (
                <>
                  {' · '}
                  <span className="font-medium text-red-600 dark:text-red-400">{parsed.errors.length} skipped</span>
                </>
              )}
              {' from '}{fileName}
            </p>
            {parsed.errors.length > 0 && (
              <ul className="max-h-32 overflow-y-auto text-xs text-red-600 dark:text-red-400">
                {parsed.errors.map((e) => (
                  <li key={e.row}>Row {e.row} ({e.assetTag}): {e.problems.join(', ')}</li>
                ))}
              </ul>
            )}
          </div>
        )}

        {importError && <p className="text-sm text-red-600 dark:text-red-400">{importError}</p>}

        <div className="mt-2 flex justify-end gap-2">
          <button
            type="button"
            onClick={handleClose}
            className="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
          >
            Cancel
          </button>
          <button
            type="button"
            onClick={handleImport}
            disabled={!parsed || parsed.valid.length === 0 || importing}
            className="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-60"
          >
            {importing ? 'Importing…' : `Import ${parsed?.valid.length ?? ''} assets`}
          </button>
        </div>
      </div>
    </div>
  );
}

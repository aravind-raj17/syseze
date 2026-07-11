import jsPDF from 'jspdf';
import logoUrl from '../assets/syseze-logo.png';

// Syseze logo is 966x497 px (navy background baked into the PNG).
const LOGO_ASPECT = 966 / 497;
const BRAND_NAVY = [43, 37, 96];
const HEADER_HEIGHT = 22;

let cachedLogoDataUrl = null;
async function loadLogoDataUrl() {
  if (cachedLogoDataUrl) return cachedLogoDataUrl;
  const res = await fetch(logoUrl);
  const blob = await res.blob();
  cachedLogoDataUrl = await new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = reject;
    reader.readAsDataURL(blob);
  });
  return cachedLogoDataUrl;
}

// Creates a jsPDF doc with a branded navy header (Syseze logo + title) already
// drawn. Returns the doc and the Y position content should start below it.
export async function createBrandedDoc({ title, subtitle, orientation = 'landscape' }) {
  const doc = new jsPDF({ orientation });
  const pageWidth = doc.internal.pageSize.getWidth();

  doc.setFillColor(...BRAND_NAVY);
  doc.rect(0, 0, pageWidth, HEADER_HEIGHT, 'F');

  try {
    const logo = await loadLogoDataUrl();
    const logoH = 14;
    const logoW = logoH * LOGO_ASPECT;
    doc.addImage(logo, 'PNG', 8, (HEADER_HEIGHT - logoH) / 2, logoW, logoH);
  } catch {
    // Logo failed to load (offline, blocked fetch, etc.) — ship the report
    // without it rather than failing the whole export.
  }

  doc.setTextColor(255, 255, 255);
  doc.setFontSize(14);
  doc.text(title, pageWidth - 8, subtitle ? 11 : 13, { align: 'right' });
  if (subtitle) {
    doc.setFontSize(9);
    doc.text(subtitle, pageWidth - 8, 18, { align: 'right' });
  }

  doc.setTextColor(0, 0, 0);
  return { doc, contentStartY: HEADER_HEIGHT + 8, pageWidth };
}

// Stamps a footer (generated timestamp + page numbers) on every page. Call
// this last, once all tables/sections have been added.
export function addBrandedFooter(doc) {
  const pageCount = doc.internal.getNumberOfPages();
  const generated = `Generated ${new Date().toLocaleString()} · Syseze Asset Inventory Portal`;
  for (let i = 1; i <= pageCount; i++) {
    doc.setPage(i);
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    doc.setFontSize(8);
    doc.setTextColor(130, 130, 130);
    doc.text(generated, 8, pageHeight - 6);
    doc.text(`Page ${i} of ${pageCount}`, pageWidth - 8, pageHeight - 6, { align: 'right' });
  }
}

export const BRAND_TABLE_HEAD_STYLE = { fillColor: BRAND_NAVY };

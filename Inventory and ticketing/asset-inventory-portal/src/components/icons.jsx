// Minimal stroke-icon set for dashboard stat tiles, matching the app's
// existing feather-style icons (stroke="currentColor", round caps/joins).

const base = {
  fill: 'none',
  stroke: 'currentColor',
  strokeWidth: 2,
  strokeLinecap: 'round',
  strokeLinejoin: 'round',
};

export function ClientsIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
      <circle cx="9" cy="7" r="4" />
      <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
      <path d="M16 3.13a4 4 0 0 1 0 7.75" />
    </svg>
  );
}

export function LaptopIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="4" y="4" width="16" height="11" rx="1" />
      <path d="M2 19h20" />
    </svg>
  );
}

export function DesktopIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="3" y="4" width="18" height="12" rx="1" />
      <path d="M8 20h8M12 16v4" />
    </svg>
  );
}

export function MonitorIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="2" y="3" width="20" height="13" rx="1" />
      <path d="M8 20h8M12 16v4" />
    </svg>
  );
}

export function MouseIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="7" y="2" width="10" height="18" rx="5" />
      <path d="M12 2v6" />
    </svg>
  );
}

export function KeyboardIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="2" y="5" width="20" height="14" rx="1" />
      <path d="M6 9h.01M10 9h.01M14 9h.01M18 9h.01M6 13h.01M18 13h.01M9 13h6" />
    </svg>
  );
}

export function HeadsetIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <path d="M3 13a9 9 0 0 1 18 0" />
      <path d="M21 13v4a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3ZM3 13v4a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3Z" />
    </svg>
  );
}

export function MobileIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="6" y="2" width="12" height="20" rx="2" />
      <path d="M11 18h2" />
    </svg>
  );
}

export function NetworkIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="2" y="14" width="20" height="6" rx="1" />
      <path d="M6 14v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3M6 18h.01M10 18h.01" />
    </svg>
  );
}

export function ServerIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <rect x="2" y="3" width="20" height="7" rx="1" />
      <rect x="2" y="14" width="20" height="7" rx="1" />
      <path d="M6 6.5h.01M6 17.5h.01" />
    </svg>
  );
}

export function PrinterIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <path d="M6 9V3h12v6" />
      <rect x="2" y="9" width="20" height="8" rx="1" />
      <path d="M6 17h12v5H6z" />
    </svg>
  );
}

export function CctvIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <path d="M3 7l9-3 9 3" />
      <rect x="3" y="7" width="12" height="4" rx="1" />
      <path d="M15 9h4l2 4-6 2Z" />
      <circle cx="8" cy="9" r="1.4" />
    </svg>
  );
}

export function TicketIcon(props) {
  return (
    <svg viewBox="0 0 24 24" {...base} {...props}>
      <path d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4Z" />
      <path d="M13 6v2M13 11v2M13 16v2" />
    </svg>
  );
}

export const CATEGORY_ICONS = {
  Laptop: LaptopIcon,
  Desktop: DesktopIcon,
  Monitor: MonitorIcon,
  Mouse: MouseIcon,
  Keyboard: KeyboardIcon,
  Headset: HeadsetIcon,
  Mobile: MobileIcon,
  'Network Gear': NetworkIcon,
  Server: ServerIcon,
  Printer: PrinterIcon,
  CCTV: CctvIcon,
};

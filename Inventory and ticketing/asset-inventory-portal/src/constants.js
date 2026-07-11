export const CATEGORIES = [
  'Laptop',
  'Desktop',
  'Monitor',
  'Mouse',
  'Keyboard',
  'Headset',
  'Mobile',
  'Network Gear',
  'Server',
  'Printer',
  'CCTV',
];
export const STATUSES = ['Active', 'Available', 'In Repair', 'Retired', 'Spare'];
export const PAGE_SIZE = 15;

export const EMPTY_ASSET_FORM = {
  assetTag: '',
  clientId: '',
  category: CATEGORIES[0],
  brand: '',
  model: '',
  serialNumber: '',
  purchaseDate: '',
  warrantyExpiry: '',
  location: '',
  assignedTo: '',
  status: 'Active',
  notes: '',
};

export const EMPTY_CLIENT_FORM = {
  name: '',
  code: '',
  contactPerson: '',
  contactEmail: '',
  address: '',
};

import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';
import { getFirestore } from 'firebase/firestore';

// Fill these in from Firebase console: Project settings -> Your apps -> Web app.
// Safe to expose in frontend code — access is enforced by Firestore security
// rules (see firestore.rules), not by hiding this config.
export const firebaseConfig = {
  apiKey: 'AIzaSyAWkdz_P9_xJhiiMB1i3aX5jLm_pzo8Iyo',
  authDomain: 'asset-inventory-portal.firebaseapp.com',
  projectId: 'asset-inventory-portal',
  storageBucket: 'asset-inventory-portal.firebasestorage.app',
  messagingSenderId: '215172700685',
  appId: '1:215172700685:web:f762a19acf4dedfa72d344',
};

export const app = initializeApp(firebaseConfig);
export const auth = getAuth(app);
export const db = getFirestore(app);

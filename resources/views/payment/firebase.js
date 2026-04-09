// firebase.js - Firebase config and helpers
// 1. Add your Firebase project config below
// 2. Enable Authentication (Email/Password) and Realtime Database in Firebase Console

const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "YOUR_AUTH_DOMAIN",
  databaseURL: "YOUR_DATABASE_URL",
  projectId: "YOUR_PROJECT_ID",
  storageBucket: "YOUR_STORAGE_BUCKET",
  messagingSenderId: "YOUR_MESSAGING_SENDER_ID",
  appId: "YOUR_APP_ID"
};

firebase.initializeApp(firebaseConfig);
const db = firebase.database();
const auth = firebase.auth();

// Helper: Save payment
function savePayment(payment) {
  const newRef = db.ref('payments').push();
  return newRef.set(payment);
}

// Helper: Get all payments (real-time)
function listenPayments(callback) {
  db.ref('payments').on('value', snapshot => {
    const data = snapshot.val() || {};
    callback(Object.entries(data).map(([id, val]) => ({ id, ...val })));
  });
}

// Helper: Delete payment (admin only)
function deletePayment(id) {
  return db.ref('payments/' + id).remove();
}

// Helper: Update payment
function updatePayment(id, data) {
  return db.ref('payments/' + id).update(data);
}

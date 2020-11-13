importScripts("https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js");


// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
var firebaseConfig = {
  apiKey: "AIzaSyC8BOE-GDJXi4a1AHEgkfWfS8H27DsTNjM",
  authDomain: "visit-app-81660.firebaseapp.com",
  databaseURL: "https://visit-app-81660.firebaseio.com",
  projectId: "visit-app-81660",
  storageBucket: "visit-app-81660.appspot.com",
  messagingSenderId: "655133351286",
  appId: "1:655133351286:web:4db0428856c895ec02ee57"
};
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();
const url = '';

messaging.onBackgroundMessage(function(payload) {
  if (payload.data.type == 'ruang') {
    const notificationTitle = 'Permintaan Kunjungan';
    const notificationOptions = {
      body: payload.data.message,
      icon: payload.data.icon,
      data: {
        click_action: payload.data.url
      }
    }
    self.registration.showNotification(notificationTitle,notificationOptions);
  }
  if (payload.data.type == 'guest') {
    const notificationTitle = 'Status Permintaan Kunjungan';
    const notificationOptions = {
      body: payload.data.message,
      icon: payload.data.icon,
      data: {
        click_action: payload.data.url
      }
    }
    self.registration.showNotification(notificationTitle,notificationOptions);
  }
});
self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(self.clients.openWindow(event.notification.data.click_action));
});

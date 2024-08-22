@if(config('app.firebase.status'))
importScripts('https://www.gstatic.com/firebasejs/8.4.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.4.2/firebase-messaging.js');

// messagingSenderId.
firebase.initializeApp({
    apiKey: "{{ config('app.firebase.apiKey') }}",
    authDomain: "{{ config('app.firebase.authDomain') }}",
    projectId: "{{ config('app.firebase.projectId') }}",
    storageBucket: "{{ config('app.firebase.storageBucket') }}",
    messagingSenderId: "{{ config('app.firebase.messagingSenderId') }}",
    appId: "{{ config('app.firebase.appId') }}"
});

const messaging = firebase.messaging();
 
messaging.setBackgroundMessageHandler(function(payload) {

  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon,
  };
  
  return self.registration.showNotification(payload.notification.title, notificationOptions); 
});
@endif
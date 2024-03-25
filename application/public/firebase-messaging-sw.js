// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyA57QHsvQcx1OCPIyA92Vs78xiQ9t-hnTA",
    authDomain: "nsn-hotels.firebaseapp.com",
    projectId: "nsn-hotels",
    storageBucket: "nsn-hotels.appspot.com",
    messagingSenderId: "1098625418948",
    appId: "1:1098625418948:web:07cffeebca114606ca6b91",
    measurementId: "G-4NBSM463QS"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = payload.title;
    const options = {
        body: payload.body,
        icon: "https://d27s5h82rwvc4v.cloudfront.net/uploads/6426b663b038f1680258659.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});

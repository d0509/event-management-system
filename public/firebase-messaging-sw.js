importScripts('https://www.gstatic.com/firebasejs/5.5.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/5.5.8/firebase-messaging.js');

var config = {
    apiKey: "AIzaSyAu2dsRuu3ls4v5Mo9sYcjttjOnJ20PYkI",
    authDomain: "broadcast-notification-56381.firebaseapp.com",
    databaseURL: "https://broadcast-notification-56381.firebaseio.com",
    projectId: "broadcast-notification-56381",
    storageBucket: "broadcast-notification-56381.appspot.com",
    messagingSenderId: "268623408616"
};
firebase.initializeApp(config);

// Retrieve Firebase Messaging object.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function (payload) {

    var title = payload.data.title;

    var options = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image,
        data: {
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action
        }

    };
    return self.registration.showNotification(title, options);


});



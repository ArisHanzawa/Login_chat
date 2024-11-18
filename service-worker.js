self.addEventListener('push', function(event){
    const data = event.data.json();
    const options = {
        body: data.body,
        icon: 'https://via.placeholder.com/128',
        badge: 'https://via.placeholder.com/64',
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event){
    event.notification.close();
    event.waitUntil(
        clients.openSindow('https://localhost:8080')
    );
});
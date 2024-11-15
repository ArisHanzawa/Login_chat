self.addEventListener('push', function(event){
    const data = event.data.json();
    const options = {
        body: data.body,
        icon: '',
        badge: ''
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event){
    event.notification.close();
    event.waitUntil(
        clients
        
        
        ('https://localhost:8080')
    );
});
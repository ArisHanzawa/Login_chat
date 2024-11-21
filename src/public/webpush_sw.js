self.addEventListener('push', async function (event) {
    const jsonData = event.data.json();

    const options = {
        body: jsonData.body,
        icon: 'data/images/icon.jpg',
        data: {
            url: jsonData.url,
            sendarId: jsonData.senderId
        }
    };

    event.waitUntil(
        self.registration.showNotification(jsonData.title, options)
    );
    console.log('プッシュ通知を受信しました:', jsonData);

    if (jsonData.senderId != self.registration.scope) {
        console.log('別のユーザーからの通知を受信しました:', jsonData.senderId);
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(windowClients => {
            for (let client of windowClients) {
                if (client.url === event.notification.data.url && 'focus' in client) {
                    return client.focus();
                }
                if (client.url === event.notification.data.url) {
                    return client.navigate(event.notification.data.url);
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(event.notification.data.url);
            }
        })
    );
    console.log('通知がクリックされました:', event.notification.data.url);
});




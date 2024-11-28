self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        clients.claim()
    );
});

self.addEventListener('push', async function (event) {
    console.log('Push event received:', event);
    const jsonData = event.data.json();

    const options = {
        body: jsonData.body,
        data: {
            url: jsonData.url,
            senderId: jsonData.senderId
        }
    };

    event.waitUntil(
        self.registration.showNotification(jsonData.title, options)
    );
    console.log('プッシュ通知を受信しました:', jsonData);

    if (jsonData.senderId != self.registration.scope) {
        //location.reload();
        //location.href = location.href;
        // window.location.reload();
        console.log('別のユーザーからの通知を受信しました:', jsonData.senderId);
    }

    const clientList = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
    for (const client of clientList) {
        if (client.url === jsonData.url && 'focus' in client) {
            console.log('Sending refresh message to client:', client);
            client.postMessage({ action: 'refresh' });
        }
    }
});

self.addEventListener('notificationclick', async function (event) {
    event.notification.close();
    console.log('通知クリックイベント:', event.notification.data);
    console.log('通知のURL:', event.notification.data.url);
    event.waitUntil(
        self.clients.matchAll({ type: 'window' }).then(windowClients => {
            for (let client of windowClients) {
                if (client.url === event.notification.data.url && 'focus' in client) {
                    return client.focus();
                }
                if (client.url === event.notification.data.url) {
                    return client.navigate(event.notification.data.url);
                }
            }
            if (self.clients.openWindow) {
                return self.clients.openWindow(event.notification.data.url);
            }
        })
    );
    console.log('通知がクリックされました:', event.notification.data.url);
});




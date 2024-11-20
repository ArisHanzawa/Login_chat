//let url = "localhost:8080/webpush"; //定数化して取るのではなく、通知データから直接取得　XSS対策まぁこれある時点で意味ないんすけど

self.addEventListener('push', async function (event) {
    console.log('Push event received:', event);
    const jsonData = event.data.json();

    url = jsonData.data.url;

    event.waitUntil(
        self.registration.showNotification(jsonData.title, {
            body: jsonData.body,
        }),
    );
});

self.addEventListener('notificationclick', function (event) {
    console.log('Notification click event:', event);
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
        //clients.openWindow(url)
    );

});




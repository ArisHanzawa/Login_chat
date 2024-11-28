const applicationServerKey = 'BAE8NBkN30kgOlKzEe7OdWZRClYj6uErIof8AD2a5WDz3N_tPe2EB_1onfF40V8n-UG73yY2k1s7XF4C3MhHrxU';

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/webpush_sw.js')
        .then(function(registration) {
            console.log('Service Worker registered with scope:', registration.scope);

            registration.onupdatefound = function() {
                const installingWorker = registration.installing;
                installingWorker.onstatechange = function() {
                    if (installingWorkeer.state === 'installed') {
                        if (navigator.serviceWorker.controller) {
                        console.log('New or updated content is available.');
                        window.location.reload();
                        } else {
                        console.log('Content is now available offline!');
                        }
                    }
                };
            };

        }).catch(function(error) {
            console.log('Service Worker registration failed:', error);
        });
    navigator.serviceWorker.addEventListener('message', function(event) {
        console.log('Received message from Service Worker:', event.data);
        if (event.data.action === 'refresh') {
            location.replace(location.href);
        }
    });
}

function urlBase64ToUint8Array (base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for(let i = 0; i < rawData.length; i++) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

async function getPermission() {
    console.log('Requesting notification permission...');
    const result = await Notification.requestPermission();

    try {

        if (result !== 'granted') {
            console.log('Permission not granted for Notification');
            return;
        }

        console.log('Notification permission granted.');

        const swr = await navigator.serviceWorker.ready;


            const subscription = await swr.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(applicationServerKey)
            });

            console.log('Subscription:', subscription);

            let contentEncoding = 'aesgcm';
            if(PushManager.supportedContentEncodings && PushManager.supportedContentEncodings.includes('aes128gcm')) {
                contentEncoding = 'aes128gcm';
            }

            await fetch('set-subscription', {
                method: 'POST',
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(Object.assign(subscription.toJSON(), {contentEncoding}))
            });

            console.log('Subscription registered successfully');
            alert('プッシュサーバーの登録が完了');
        } catch(error) {
            console.error('Error during subscription:', error);
        }
}
async function updateSw() {
    const swr = await navigator.serviceWorker.ready;
    swr.update();
}

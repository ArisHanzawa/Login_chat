import './bootstrap';
import { createApp } from 'vue';

// SCSSファイルのインポート
import '../sass/app.scss';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

app.mount('#app');

async function registerServiceWorker() {
    if ('serviceWorker' in navigator) {
        try {
            const registration = await navigator.serviceWorker.register('/service-worker.js', { scope: '/' });
            console.log('Service Worker registered with scope:', registration/scope);
        } catch (error) {
            console.log('Service Worker registration failed:', error);
        }
    }
}

registerServiceWorker();

import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// Ensure Vue mounts after DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    const app = createApp(App);
    app.use(createPinia());
    app.use(router);

    router.isReady().then(() => {
        app.mount("#app");
    });
});

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import UserLoginForm from './components/UserLoginForm.vue';
import UserRegisterForm from './components/UserRegisterForm.vue';
import AdminLoginForm from './components/AdminLoginForm.vue';
import { useAuthFormStore } from './stores/authFormStore';

const appName = document.body.dataset.app;
const payload = window.__ITEROSS__ || {};

const registry = {
    'user-login': UserLoginForm,
    'user-register': UserRegisterForm,
    'admin-login': AdminLoginForm,
};

const component = registry[appName];

if (component) {
    const pinia = createPinia();
    const app = createApp(component, payload);
    app.use(pinia);
    app.mount('#app');

    const store = useAuthFormStore();
    if (payload.old) {
        store.bootstrap(payload.old);
    }
}

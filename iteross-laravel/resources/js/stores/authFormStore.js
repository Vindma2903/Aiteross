import { defineStore } from 'pinia';

export const useAuthFormStore = defineStore('auth-form', {
    state: () => ({
        first_name: '',
        last_name: '',
        company_name: '',
        phone: '',
        email: '',
        password: '',
        password_confirmation: '',
        remember: false,
    }),
    actions: {
        bootstrap(values) {
            Object.assign(this, values);
        },
    },
});

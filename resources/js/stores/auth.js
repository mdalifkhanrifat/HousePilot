import { defineStore } from 'pinia';
import axios from 'axios';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(email, password) {
            try {
                let response = await axios.post('/api/login', { email, password });
                this.token = response.data.token;
                localStorage.setItem('token', this.token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                await this.fetchUser();
            } catch (error) {
                console.error('Login failed', error);
            }
        },
        async fetchUser() {
            try {
                let response = await axios.get('/api/user');
                this.user = response.data;
            } catch (error) {
                console.error('Fetching user failed', error);
            }
        },
        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        }
    }
});

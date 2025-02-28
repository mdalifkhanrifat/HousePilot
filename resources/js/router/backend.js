import { createRouter, createWebHistory } from 'vue-router';
import BackendLayout from '@/components/layouts/BackendLayout.vue';
import Dashboard from '@/pages/backend/Dashboard.vue';
import Users from '@/pages/backend/Users.vue';

const backendRoutes = [
    {
        path: '/admin',
        component: BackendLayout,
        children: [
            { path: '', name: 'dashboard', component: Dashboard },
            { path: 'users', name: 'users', component: Users }
        ]
    }
];

export default backendRoutes;

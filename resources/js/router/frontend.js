import { createRouter, createWebHistory } from 'vue-router';
import FrontendLayout from '@/components/layouts/FrontendLayout.vue';
import Home from '@/pages/frontend/Home.vue';

const frontendRoutes = [
    {
        path: '/',
        component: FrontendLayout,
        children: [
            { path: '', name: 'home', component: Home }
        ]
    }
];

export default frontendRoutes;

import { createRouter, createWebHistory } from 'vue-router';
import frontendRoutes from '@/components/frontend/router';
import backendRoutes from '@/components/backend/router';
import authRoutes from '@/components/auth/router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...frontendRoutes,
        ...backendRoutes,
        ...authRoutes
    ],
});

export default router;
import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import frontendRoutes from '@/router/frontend';
import backendRoutes from '@/router/backend';
import authRoutes from '@/router/auth';

// NotFound Lazy-loaded
const NotFound = () => import('@/views/errors/NotFound.vue');

// Determine Router Mode from .env
const routerMode = import.meta.env.VITE_ROUTER_MODE || 'history';
const isHashMode = routerMode === 'hash';

console.info('Router Mode:', routerMode);

const router = createRouter({
    history: isHashMode ? createWebHashHistory() : createWebHistory(),
    routes: [
        ...frontendRoutes,
        ...backendRoutes,
        ...authRoutes,
        { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
    ],
    scrollBehavior() {
        return { top: 0 }; // Scroll to top on route change
    },
});

// Global Navigation Guard (Authentication Protection)
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ path: '/login', query: { redirect: to.fullPath } });
    } else if (to.meta.guestOnly && authStore.isAuthenticated) {
        next({ path: '/' }); // Prevent logged-in user from accessing guest pages
    } else {
        next();
    }
});

export default router;

// File: src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import frontendRoutes from './frontend'
import backendRoutes from './backend'
import authRoutes from './auth'
import NotFoundLayout from '@/views/common/NotFound.vue'
import { useAuthStore } from '@/stores/auth'

// const isAuthenticated = () => {
//   return !!localStorage.getItem('access_token')
// }

const routes = [
  frontendRoutes,
  authRoutes,
  {
    ...backendRoutes,
    meta: { requiresAuth: true },
  },
  {
    path: '/:pathMatch(.*)*',
    component: NotFoundLayout
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// global navigation guard
router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()
  const token = localStorage.getItem('access_token')

  if (token && !auth.user) {
    await auth.fetchUser()
  }

  if (to.matched.some(record => record.meta.requiresAuth) && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router

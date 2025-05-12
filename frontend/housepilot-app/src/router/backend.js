import BackendLayout from '@/views/layouts/BackendLayout.vue'
import Dashboard from '@/views/backend/Dashboard.vue'
import Users from '@/views/backend/Users.vue'

export default {
  path: '/admin',
  component: BackendLayout,
  children: [
    { path: 'dashboard', component: Dashboard },
    { path: 'users', component: Users }
  ]
}
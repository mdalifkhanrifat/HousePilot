import DefaultLayout from '@/views/backend/layouts/DefaultLayout.vue'
import Dashboard from '@/views/backend/pages/Dashboard.vue'

export default {
  path: '/admin',
  component: DefaultLayout,
  children: [
    { path: 'dashboard', component: Dashboard },
    // others page routes
  ]
}
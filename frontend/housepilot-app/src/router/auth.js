import Login from '@/views/frontend/auth/Login.vue'
import Register from '@/views/frontend/auth/Register.vue'
import ForgotPassword from '@/views/frontend/auth/ForgotPassword.vue'
import FrontendLayout from '@/views/frontend/layouts/FrontendLayout.vue'

export default {
  path: '/',
  component: FrontendLayout,
  children: [
    { path: 'login', component: Login },
    { path: 'register', component: Register },
    { path: 'forgot-password', component: ForgotPassword }
  ]
}

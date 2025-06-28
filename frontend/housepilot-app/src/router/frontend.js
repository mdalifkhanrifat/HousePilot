// src/router/frontend.js
import FrontendLayout from '@/views/frontend/layouts/FrontendLayout.vue'
import Home from '@/views/frontend/pages/Home.vue'
import About from '@/views/frontend/pages/About.vue'

export default {
  path: '/',
  component: FrontendLayout,
  children: [
    { path: '', component: Home },
    { path: 'about', component: About }
  ]
}

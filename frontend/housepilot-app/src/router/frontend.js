// src/router/frontend.js
import FrontendLayout from '@/views/frontend/layouts/FrontendLayout.vue'
import Home from '@/views/frontend/Home.vue'
// import About from '@/views/frontend/About.vue'

export default {
  path: '/',
  component: FrontendLayout,
  children: [
    { path: '', component: Home },
    // { path: 'about', component: About }
  ]
}

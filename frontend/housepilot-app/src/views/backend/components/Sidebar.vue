<template>
  <aside class="bg-white dark:bg-gray-800 w-64 h-full shadow-md flex flex-col p-4">
    <div class="text-xl font-bold mb-6 text-green-600">HousePilot</div>
    <nav>
      <ul class="space-y-1">
        <li v-for="link in links" :key="link.name">
          <router-link
            :to="link.route"
            class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm transition-all"
            :class="[
              'hover:bg-gray-100 dark:hover:bg-gray-700',
              'text-gray-800 dark:text-white',
              'bg-gray-100 dark:bg-neutral-700'
            ]"
          >
            <component :is="link.icon" class="shrink-0 w-4 h-4" />
            {{ link.name }}
          </router-link>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { h } from 'vue'

const links = [
  {
    name: 'Dashboard',
    route: '/admin/dashboard',
    icon: () =>
      h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: 'none',
        viewBox: '0 0 24 24',
        stroke: 'currentColor',
        class: 'w-4 h-4',
        innerHTML: `<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />`
      })
  },
  {
    name: 'Users',
    route: '/admin/users',
    icon: () =>
      h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: 'none',
        viewBox: '0 0 24 24',
        stroke: 'currentColor',
        class: 'w-4 h-4',
        innerHTML: `<path d="M17 21v-2a4 4 0 00-3-3.87M9 21v-2a4 4 0 013-3.87M16 3.13a4 4 0 11-8 0 4 4 0 018 0z"/>`
      })
  },
  {
    name: 'Settings',
    route: '/admin/settings',
    icon: () =>
      h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: 'none',
        viewBox: '0 0 24 24',
        stroke: 'currentColor',
        class: 'w-4 h-4',
        innerHTML: `<circle cx="12" cy="12" r="3" />
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />`
      })
  }
]
</script>

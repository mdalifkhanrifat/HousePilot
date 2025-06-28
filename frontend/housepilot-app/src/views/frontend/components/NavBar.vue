<template>
  <header class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <RouterLink to="/" class="text-2xl font-bold text-green-600">HousePilot</RouterLink>
      <!-- User Info (if logged in) -->
      <div v-if="auth.user" class="text-sm text-gray-800 dark:text-gray-200 mt-2 sm:mt-0">
        👋 {{ auth.user.name }} ({{ auth.user.email }})
      </div>
      <nav class="flex items-center space-x-4 text-sm font-medium text-gray-700 dark:text-gray-200">
        <RouterLink to="/" class="hover:underline">Home</RouterLink>
        <RouterLink to="/about" class="hover:underline">About</RouterLink>
        <!-- <RouterLink to="/login" class="hover:underline">Login</RouterLink>
        <RouterLink to="/register" class="hover:underline">Register</RouterLink>
        <button @click="toggleTheme" class="ml-4 px-2 py-1 border rounded">
          {{ isDark ? 'Light' : 'Dark' }}
        </button> -->

        <button
          @click="toggleTheme"
          class="text-sm px-3 py-1 border rounded text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
        >
          {{ isDark ? '☀️' : '🌙' }}
        </button>

        <!-- Auth Links -->
        <template v-if="auth.user">
          <button
            @click="auth.logout"
            class="bg-red-500 text-white text-sm px-3 py-1 rounded hover:bg-red-600"
          >
            Logout
          </button>
        </template>
        <template v-else>
          <RouterLink to="/login" class="text-sm text-blue-600 hover:underline">Login</RouterLink>
          <RouterLink to="/register" class="text-sm text-blue-600 hover:underline">Register</RouterLink>
        </template>

      </nav>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useSettingsStore } from '@/stores/settings'
import { useAuthStore } from '@/stores/auth'
const settings = useSettingsStore()
const auth = useAuthStore()

const isDark = computed(() => settings.theme === 'dark')
const toggleTheme = () => settings.toggleTheme()

</script>

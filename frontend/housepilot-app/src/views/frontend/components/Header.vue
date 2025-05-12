<!-- // ✅ File: src/views/frontend/components/Header.vue -->
<template>
  <header class="flex items-center justify-between px-6 py-4 shadow bg-white dark:bg-gray-800">
    <h1 class="text-xl font-bold text-green-600">HousePilot</h1>

    <template v-if="auth.user">
        <span class="text-gray-700 dark:text-gray-200 font-medium">
          {{ auth.user.name }} :
          {{ auth.user.email }}

        </span>
      </template>

    <nav class="space-x-4 flex items-center">
      <button @click="$settings.toggleTheme()" class="ml-4 px-2 py-1 border rounded">
        {{ $settings.theme === 'dark' ? 'Light' : 'Dark' }}
      </button>

      

      <RouterLink to="/" class="hover:underline">Home</RouterLink>
      <RouterLink to="/about" class="hover:underline">About</RouterLink>

      <template v-if="auth.user">
        <button
          @click="auth.logout"
          class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
        >
          Logout
        </button>
      </template>

      <template v-else>
        <RouterLink to="/login" class="hover:underline">Login</RouterLink>
        <RouterLink to="/register" class="hover:underline">Register</RouterLink>
      </template>
    </nav>
  </header>
</template>

<script setup>
import { useSettingsStore } from '@/stores/settings'
import { useAuthStore } from '@/stores/auth'

const $settings = useSettingsStore()
const auth = useAuthStore()
</script>

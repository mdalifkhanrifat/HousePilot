<template>
  <header
    class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
  >
    <!-- Sidebar Toggle (All devices) -->
    <button
      class="text-gray-600 dark:text-gray-200"
      @click="$emit('toggle-sidebar')"
      aria-label="Toggle Sidebar"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Page Title -->
    <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Dashboard</h1>

    <!-- Right Side Controls -->
    <div class="flex items-center space-x-4">
      <!-- Theme Toggle -->
      <button
        @click="toggleTheme()"
        class="text-sm px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
        title="Toggle Theme"
      >
        {{ isDark ? '☀️' : '🌙' }}
      </button>

      <!-- Notification Button -->
      <button
        aria-label="Notifications"
        class="relative text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none"
      >
        <svg
          class="h-6 w-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          ></path>
        </svg>
        <!-- Notification badge example -->
        <span
          v-if="notificationsCount > 0"
          class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
        >
          {{ notificationsCount }}
        </span>
      </button>

      <!-- User Dropdown -->
      <div class="relative" id="user-dropdown">
        <button
          @click="dropdownOpen = !dropdownOpen"
          class="flex items-center space-x-2 focus:outline-none"
          aria-haspopup="true"
          aria-expanded="dropdownOpen.toString()"
        >
          <img
            src="https://i.pravatar.cc/40"
            alt="User Avatar"
            class="w-8 h-8 rounded-full object-cover"
          />
          <span class="text-gray-800 dark:text-gray-100 font-medium">{{ auth.user.name }}</span>
          <svg
            class="w-4 h-4 text-gray-600 dark:text-gray-300"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Dropdown menu -->
        <transition
          enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95"
        >
          <div
            v-if="dropdownOpen"
            class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
          >
            <button
              @click="auth.logout"
              class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
            >
              Log Out
            </button>
          </div>
        </transition>
      </div>

    </div>
  </header>
</template>

<script setup>
// import { ref } from 'vue'
import { ref, onMounted, onBeforeUnmount } from 'vue'

import { computed } from 'vue'
import { useSettingsStore } from '@/stores/settings'
import { useAuthStore } from '@/stores/auth'

const settings = useSettingsStore()
const auth = useAuthStore()
const isDark = computed(() => settings.theme === 'dark')
const toggleTheme = () => settings.toggleTheme()

const dropdownOpen = ref(false)
const notificationsCount = 3


  const handleClickOutside = (event) => {
    const dropdown = document.getElementById('user-dropdown')
    if (dropdown && !dropdown.contains(event.target)) {
      dropdownOpen.value = false
    }
  }

  onMounted(() => {
    document.addEventListener('click', handleClickOutside)
  })

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
  })

</script>

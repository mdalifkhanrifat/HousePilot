<template>
  <div :class="{ dark: $settings.theme === 'dark' }" class="min-h-screen">
    <div class="flex bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">

      <!-- Sidebar (Fixed Width) -->
      <div v-show="isSidebarOpen" class="hidden md:block w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
        <Sidebar />
      </div>

      <!-- Overlay for mobile -->
      <div
        v-if="isSidebarOpen && !isDesktop"
        class="fixed inset-0 z-30 bg-black bg-opacity-50"
        @click="toggleSidebar"
      ></div>

      <!-- Main content -->
      <div class="flex flex-col flex-1 min-h-screen">
        <!-- Header -->
        <Header @toggle-sidebar="toggleSidebar" class="sticky top-0 z-20 shadow" />

        <!-- Main view -->
        <main class="flex-1 px-4 pt-6 pb-10 overflow-y-auto">
          <router-view />
        </main>

        <!-- Footer -->
        <Footer />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useSettingsStore } from '@/stores/settings'
import Sidebar from '@/views/backend/components/Sidebar.vue'
import Header from '@/views/backend/components/Header.vue'
import Footer from '@/views/backend/components/Footer.vue'

const $settings = useSettingsStore()
const isSidebarOpen = ref(true)
const isDesktop = ref(window.innerWidth >= 768)

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 768
  if (!isDesktop.value) {
    isSidebarOpen.value = false
  } else {
    isSidebarOpen.value = true
  }
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
  handleResize()
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})
</script>

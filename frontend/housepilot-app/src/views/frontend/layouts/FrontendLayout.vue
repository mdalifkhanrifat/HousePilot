<!-- // ✅ File: src/views/layouts/FrontendLayout.vue -->
<template>
  <div :class="[$settings.theme === 'dark' ? 'dark' : '']">
    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
      <HeaderSection />
      <router-view />
      <FooterSection />
    </div>
  </div>
</template>

<script setup>
import HeaderSection from '../components/HeaderSection.vue'
import FooterSection from '../components/FooterSection.vue'
import { useSettingsStore } from '@/stores/settings'

const $settings = useSettingsStore()

</script>

<style scoped></style>

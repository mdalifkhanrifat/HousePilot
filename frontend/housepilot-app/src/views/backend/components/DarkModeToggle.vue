<template>
  <button @click="toggleTheme" class="hs-dark-mode relative flex justify-center items-center size-7 border border-gray-200 text-gray-500 rounded-full hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
    <span class="sr-only">Toggle Dark Mode</span>
    <svg v-if="!isDarkMode" class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
    </svg>
    <svg v-else class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="4"></circle>
      <path d="M12 2v2"></path>
      <path d="M12 20v2"></path>
      <path d="m4.93 4.93 1.41 1.41"></path>
      <path d="m17.66 17.66 1.41 1.41"></path>
      <path d="M2 12h2"></path>
      <path d="M20 12h2"></path>
      <path d="m6.34 17.66-1.41 1.41"></path>
      <path d="m19.07 4.93-1.41 1.41"></path>
    </svg>
  </button>
</template>

<script>
import { useThemeStore } from '../../../stores/themes/themeStore';

export default {
  setup() {
    const themeStore = useThemeStore();
    const toggleTheme = () => {
      themeStore.toggleTheme();
    };

    return {
      toggleTheme,
      isDarkMode: themeStore.isDarkMode
    };
  }
}
</script>

<style scoped>
/* এখানে অতিরিক্ত স্টাইল যুক্ত করতে পারেন যদি প্রয়োজন হয় */
</style>
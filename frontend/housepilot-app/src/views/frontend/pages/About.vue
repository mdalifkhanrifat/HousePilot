<!-- src/views/frontend/pages/Home.vue -->
<template>
  <section class="px-4 py-20 text-center max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-4">Welcome to HousePilot About page</h1>
    <p class="text-lg mb-6">A modern, responsive SaaS platform for managing your house with ease.</p>
    <div class="flex justify-center space-x-4">
      <RouterLink to="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Get Started</RouterLink>
      <RouterLink to="/login" class="bg-gray-200 dark:bg-gray-700 dark:text-white text-gray-900 px-6 py-2 rounded">Login</RouterLink>
    </div>
  </section>
</template>

<script setup>
// ❌ HeaderSection, Footer import বাদ
</script>

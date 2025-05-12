<!-- // ✅ File: src/views/frontend/components/ClientsSection.vue -->
<template>
  <section class="py-12 px-6 text-center">
    <h3 class="text-xl font-semibold mb-4">Our Clients</h3>
    <p class="mb-6 text-gray-600 dark:text-gray-300">We have been working with some Fortune 500+ clients</p>
    <div class="flex flex-wrap justify-center gap-4">
      <div v-for="n in 6" :key="n" class="bg-gray-200 dark:bg-gray-700 w-20 h-10 rounded"></div>
    </div>
  </section>
</template>

<script setup></script>
<!-- ✅ File: src/views/backend/pages/Dashboard.vue -->
<template>
  <DefaultLayout>
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Dashboard Overview</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
          <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
          <p class="text-2xl font-bold">1,234</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
          <p class="text-sm text-gray-500 dark:text-gray-400">Active Sessions</p>
          <p class="text-2xl font-bold">87</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
          <p class="text-sm text-gray-500 dark:text-gray-400">Revenue</p>
          <p class="text-2xl font-bold">$12,340</p>
        </div>
        <Btn/>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
// import DefaultLayout from '../layouts/DefaultLayout.vue';
</script>

<style scoped>
</style>

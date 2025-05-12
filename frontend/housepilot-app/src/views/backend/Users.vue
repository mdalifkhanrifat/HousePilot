//  File: src/views/backend/Users.vue
<template>
  <div class="p-6 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <h1 class="text-2xl font-bold mb-4">Users Management</h1>
    <ul>
      <li v-for="i in 5" :key="i" class="py-2 border-b border-gray-300 dark:border-gray-700">
        User #{{ i }}
      </li>
    </ul>
  </div>
</template>

<script setup></script>
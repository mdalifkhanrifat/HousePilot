<!-- // ✅ File: src/views/frontend/components/FooterSection.vue -->
<template>
  <footer class="bg-gray-100 dark:bg-gray-900 border-t dark:border-gray-700 mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-sm text-gray-700 dark:text-gray-300">
      <!-- Column 1 -->
      <div>
        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">HousePilot</h3>
        <p class="text-gray-600 dark:text-gray-400">
          Manage your home with confidence and clarity. HousePilot is your all-in-one SaaS solution.
        </p>
      </div>

      <!-- Column 2 -->
      <div>
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Quick Links</h4>
        <ul class="space-y-1">
          <li><RouterLink to="/" class="hover:underline">Home</RouterLink></li>
          <li><RouterLink to="/about" class="hover:underline">About</RouterLink></li>
          <li><RouterLink to="/login" class="hover:underline">Login</RouterLink></li>
          <li><RouterLink to="/register" class="hover:underline">Register</RouterLink></li>
        </ul>
      </div>

      <!-- Column 3 -->
      <div>
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Connect</h4>
        <p>Email: <a href="mailto:support@housepilot.com" class="hover:underline">support@housepilot.com</a></p>
        <p class="mt-1">Phone: +880-1234-567890</p>
      </div>
    </div>

    <div class="border-t mt-6 border-gray-200 dark:border-gray-700 text-center py-4 text-xs text-gray-500 dark:text-gray-400">
      © {{ new Date().getFullYear() }} HousePilot. All rights reserved.
    </div>
  </footer>
</template>

<script setup></script>


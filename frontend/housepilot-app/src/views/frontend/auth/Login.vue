<!-- //  File: src/views/frontend/auth/Login.vue -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 p-8 rounded shadow w-full max-w-md">
      <h2 class="text-2xl font-bold mb-4 text-center text-gray-800 dark:text-white">Login</h2>
      <form @submit.prevent="login">
        <input
          type="email"
          v-model="email"
          placeholder="Email"
          class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-white"
        />
        <input
          type="password"
          v-model="password"
          placeholder="Password"
          class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-white"
        />
        <p v-if="auth.error" class="text-red-500 mb-2">{{ auth.error }}</p>
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Login</button>
      </form>
    </div>
  </div>
</template>

<script setup>

  import { ref } from 'vue'
  import { useAuthStore } from '@/stores/auth'

  const auth = useAuthStore()
  const email = ref('')
  const password = ref('')

  const login = () => {
    auth.login({ email: email.value, password: password.value })
  }

</script>



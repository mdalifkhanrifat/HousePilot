// File: src/views/frontend/auth/Register.vue
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 p-8 rounded shadow w-full max-w-md">
      <h2 class="text-2xl font-bold mb-4 text-center text-gray-800 dark:text-white">Register</h2>
      <form @submit.prevent="handleRegister">
        <input
          type="text"
          v-model="name"
          placeholder="Name"
          class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-white"
        />
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
        <input
          type="password"
          v-model="confirmPassword"
          placeholder="Confirm Password"
          class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-white"
        />
        <p v-if="auth.error" class="text-red-500 mb-2">{{ auth.error }}</p>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Register</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')

const handleRegister = () => {
  if (password.value !== confirmPassword.value) {
    auth.error = 'Passwords do not match.'
    return
  }

  auth.register({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: confirmPassword.value
  })
}
</script>

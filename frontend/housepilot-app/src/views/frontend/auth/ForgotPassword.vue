<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
      <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Forgot Password</h2>
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="w-full mb-4 p-2 border rounded dark:bg-gray-700 dark:text-white"
        />
        <p v-if="message" class="text-green-500">{{ message }}</p>
        <p v-if="error" class="text-red-500">{{ error }}</p>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Send Reset Link</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import api from '@/lib/axios'
  
  const email = ref('')
  const message = ref('')
  const error = ref('')
  
  const submit = async () => {
    message.value = ''
    error.value = ''
    try {
      const res = await api.post('/api/forgot-password', { email: email.value })
      message.value = res.data.message
    } catch (err) {
      error.value = err.response?.data?.message || 'Something went wrong'
    }
  }
  </script>
  
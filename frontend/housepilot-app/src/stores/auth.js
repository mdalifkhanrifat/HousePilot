// File: src/stores/auth.js
import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/lib/axios'
import router from '@/router'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('access_token') || '')
  const error = ref('')

  const setToken = (newToken) => {
    // console.log('[DEBUG] Saving token:', newToken) // Debugging
    token.value = newToken
    localStorage.setItem('access_token', newToken)
  }
  

  const clearToken = () => {
    token.value = ''
    localStorage.removeItem('access_token')
  }


  const login = async (credentials) => {
    try {
      const response = await api.post('/api/login', credentials)
      // console.log('[DEBUG] Received token:', response.data.token)  // Debugging
      setToken(response.data.token)
      await fetchUser()
      error.value = ''
      router.push('/admin/dashboard')
    } catch (err) {
      error.value = 'Invalid credentials. Please try again.'
      console.error(err)
    }
  }
  

  const register = async (form) => {
    try {
      const response = await api.post('/api/register', form)
      setToken(response.data.token) 
      await fetchUser()
      error.value = ''
      router.push('/admin/dashboard')
    } catch (err) {
      error.value = 'Registration failed. Try again.'
      console.error(err)
    }
  }

  const fetchUser = async () => {
    try {
      const response = await api.get('/api/user') 
      user.value = response.data
    } catch (err) {
      clearToken()
      console.error('User fetch failed', err)
    }
  }

  const logout = async () => {
    try {
      await api.post('/api/logout') 
    } catch (err) {
      console.warn('Logout failed', err)
    } finally {
      clearToken()
      user.value = null
      router.push('/login')
    }
  }

  return { user, token, error, login, register, fetchUser, logout }
})

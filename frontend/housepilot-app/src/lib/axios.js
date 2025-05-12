// src/lib/axios.js

import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL, // .env to BASE URL

  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})


// Optional: Bearer token interceptor
api.interceptors.request.use(config => {
  const token = localStorage.getItem('access_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  // console.log('[DEBUG] Axios Headers:', config.headers) // // Debugging
  return config
})


export default api

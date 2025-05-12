
// ✅ File: src/stores/settings.js
import { defineStore } from 'pinia'

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    theme: 'light',
    primaryColor: '#22c55e'
  }),
  actions: {
    toggleTheme() {
      this.theme = this.theme === 'light' ? 'dark' : 'light'
    },
    setPrimaryColor(color) {
      this.primaryColor = color
    }
  }
})
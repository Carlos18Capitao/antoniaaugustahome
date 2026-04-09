import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { adminApi } from '@/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('aa_user') || 'null'))
  const token = ref(localStorage.getItem('aa_token') || null)

  const isAuthenticated = computed(() => !!token.value)

  async function login(credentials) {
    const { data } = await adminApi.login(credentials)
    token.value = data.token
    user.value = data.user
    localStorage.setItem('aa_token', data.token)
    localStorage.setItem('aa_user', JSON.stringify(data.user))
    return data
  }

  async function logout() {
    try {
      await adminApi.logout()
    } catch {
      // ignore
    }
    token.value = null
    user.value = null
    localStorage.removeItem('aa_token')
    localStorage.removeItem('aa_user')
  }

  async function fetchUser() {
    try {
      const { data } = await adminApi.me()
      user.value = data.user
      localStorage.setItem('aa_user', JSON.stringify(data.user))
    } catch {
      await logout()
    }
  }

  return { user, token, isAuthenticated, login, logout, fetchUser }
})

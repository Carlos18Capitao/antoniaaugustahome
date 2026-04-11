import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || '/api',
  headers: {
    'Accept': 'application/json',
  },
  withCredentials: true,
})

// Request interceptor — attach token and set content type
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('aa_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  // Let the browser set Content-Type automatically for FormData (multipart/form-data with boundary)
  if (!(config.data instanceof FormData)) {
    config.headers['Content-Type'] = 'application/json'
  }
  return config
})

// Response interceptor — handle 401
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('aa_token')
      localStorage.removeItem('aa_user')
      if (window.location.pathname.startsWith('/admin') && window.location.pathname !== '/admin/login') {
        window.location.href = '/admin/login'
      }
    }
    return Promise.reject(error)
  }
)

export default api

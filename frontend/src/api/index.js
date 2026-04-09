import api from './axios'

export const productApi = {
  list: (params = {}) => api.get('/products', { params }),
  featured: (limit = 8) => api.get('/products/featured', { params: { limit } }),
  show: (slug) => api.get(`/products/${slug}`),
  related: (slug) => api.get(`/products/${slug}/related`),
}

export const categoryApi = {
  list: () => api.get('/categories'),
  show: (slug) => api.get(`/categories/${slug}`),
}

export const projectApi = {
  list: (params = {}) => api.get('/projects', { params }),
  featured: () => api.get('/projects/featured'),
  show: (slug) => api.get(`/projects/${slug}`),
}

export const contactApi = {
  send: (data) => api.post('/contact', data),
}

export const pageViewApi = {
  track: (page) => api.post('/page-views', { page }),
}

// Admin APIs
export const adminApi = {
  login: (credentials) => api.post('/admin/login', credentials),
  logout: () => api.post('/admin/logout'),
  me: () => api.get('/admin/me'),

  // Dashboard
  dashboard: () => api.get('/admin/dashboard'),
  viewsChart: () => api.get('/admin/dashboard/views-chart'),

  // Products
  products: {
    list: (params = {}) => api.get('/admin/products', { params }),
    show: (id) => api.get(`/admin/products/${id}`),
    get: (id) => api.get(`/admin/products/${id}`),
    create: (data) => api.post('/admin/products', data),
    update: (id, data) => api.put(`/admin/products/${id}`, data),
    delete: (id) => api.delete(`/admin/products/${id}`),
    uploadImage: (id, formData) => api.post(`/admin/products/${id}/images`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    }),
    deleteImage: (productId, imageId) => api.delete(`/admin/products/${productId}/images/${imageId}`),
    reorderImages: (id, imageIds) => api.put(`/admin/products/${id}/images/reorder`, { image_ids: imageIds }),
  },

  // Categories
  categories: {
    list: (params = {}) => api.get('/admin/categories', { params }),
    show: (id) => api.get(`/admin/categories/${id}`),
    create: (data) => api.post('/admin/categories', data, {
      headers: { 'Content-Type': 'multipart/form-data' },
    }),
    update: (id, data) => api.post(`/admin/categories/${id}`, data, {
      headers: { 'Content-Type': 'multipart/form-data' },
    }),
    delete: (id) => api.delete(`/admin/categories/${id}`),
  },

  // Projects
  projects: {
    list: (params = {}) => api.get('/admin/projects', { params }),
    show: (id) => api.get(`/admin/projects/${id}`),
    get: (id) => api.get(`/admin/projects/${id}`),
    create: (data) => api.post('/admin/projects', data),
    update: (id, data) => api.put(`/admin/projects/${id}`, data),
    delete: (id) => api.delete(`/admin/projects/${id}`),
    uploadImage: (id, formData) => api.post(`/admin/projects/${id}/images`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    }),
    deleteImage: (projectId, imageId) => api.delete(`/admin/projects/${projectId}/images/${imageId}`),
  },

  // Leads
  leads: {
    list: (params = {}) => api.get('/admin/leads', { params }),
    show: (id) => api.get(`/admin/leads/${id}`),
    updateStatus: (id, data) => api.put(`/admin/leads/${id}/status`, data),
    delete: (id) => api.delete(`/admin/leads/${id}`),
  },
}

export default {
  products: productApi,
  categories: categoryApi,
  projects: projectApi,
  contact: contactApi,
  pageViews: pageViewApi,
  admin: adminApi,
}

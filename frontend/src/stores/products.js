import { defineStore } from 'pinia'
import { ref } from 'vue'

const BASE = import.meta.env.BASE_URL

async function loadProducts() {
  const res = await fetch(BASE + 'data/products.json')
  const json = await res.json()
  return json.data
}

export const useProductStore = defineStore('products', () => {
  const products = ref([])
  const product = ref(null)
  const categories = ref([])
  const featuredProducts = ref([])
  const relatedProducts = ref([])
  const meta = ref({})
  const loading = ref(false)

  async function fetchProducts(params = {}) {
    loading.value = true
    try {
      let data = await loadProducts()
      if (params.category_slug)
        data = data.filter(p => p.category.slug === params.category_slug)
      const page = params.page || 1
      const perPage = 12
      const total = data.length
      products.value = data.slice((page - 1) * perPage, page * perPage)
      meta.value = { current_page: page, total, per_page: perPage, last_page: Math.ceil(total / perPage) }
    } finally {
      loading.value = false
    }
  }

  async function fetchProduct(slug) {
    loading.value = true
    try {
      const data = await loadProducts()
      product.value = data.find(p => p.slug === slug) || null
    } finally {
      loading.value = false
    }
  }

  async function fetchFeatured(limit = 8) {
    const data = await loadProducts()
    featuredProducts.value = data.filter(p => p.is_featured).slice(0, limit)
  }

  async function fetchRelated(slug) {
    const data = await loadProducts()
    const current = data.find(p => p.slug === slug)
    relatedProducts.value = data
      .filter(p => p.slug !== slug && p.category?.slug === current?.category?.slug)
      .slice(0, 4)
  }

  async function fetchCategories() {
    const res = await fetch(BASE + 'data/categories.json')
    const json = await res.json()
    categories.value = json.data
  }

  return {
    products,
    product,
    categories,
    featuredProducts,
    relatedProducts,
    meta,
    loading,
    fetchProducts,
    fetchProduct,
    fetchFeatured,
    fetchRelated,
    fetchCategories,
  }
})

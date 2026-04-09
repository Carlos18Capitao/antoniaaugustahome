import { defineStore } from 'pinia'
import { ref } from 'vue'
import { productApi, categoryApi } from '@/api'

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
      const { data } = await productApi.list(params)
      products.value = data.data
      meta.value = data.meta || {}
    } finally {
      loading.value = false
    }
  }

  async function fetchProduct(slug) {
    loading.value = true
    try {
      const { data } = await productApi.show(slug)
      product.value = data.data
    } finally {
      loading.value = false
    }
  }

  async function fetchFeatured(limit = 8) {
    const { data } = await productApi.featured(limit)
    featuredProducts.value = data.data
  }

  async function fetchRelated(slug) {
    const { data } = await productApi.related(slug)
    relatedProducts.value = data.data
  }

  async function fetchCategories() {
    const { data } = await categoryApi.list()
    categories.value = data.data
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

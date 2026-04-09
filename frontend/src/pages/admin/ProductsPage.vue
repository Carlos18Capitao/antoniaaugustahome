<template>
  <div class="admin-products">
    <div class="admin-page-header">
      <h1 class="admin-page-title">Produtos</h1>
      <router-link to="/admin/produtos/novo" class="btn btn--primary btn--sm">+ Novo Produto</router-link>
    </div>

    <!-- Filters -->
    <div class="admin-filters">
      <input v-model="search" type="text" placeholder="Pesquisar produtos..." class="admin-search" />
      <select v-model="categoryFilter" class="admin-select">
        <option value="">Todas as categorias</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>
    </div>

    <!-- Table -->
    <div class="admin-card">
      <table class="admin-table" v-if="products.length">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estado</th>
            <th>Destaque</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>
              <div class="product-cell">
                <div class="product-cell__thumb" v-if="product.primary_image">
                  <img :src="product.primary_image.thumbnail_url" :alt="product.name" />
                </div>
                <span>{{ product.name }}</span>
              </div>
            </td>
            <td>{{ product.category?.name || '—' }}</td>
            <td>{{ product.formatted_price || '—' }}</td>
            <td>
              <span class="badge" :class="product.is_active ? 'badge--active' : 'badge--inactive'">
                {{ product.is_active ? 'Ativo' : 'Inativo' }}
              </span>
            </td>
            <td>{{ product.is_featured ? '★' : '—' }}</td>
            <td>
              <div class="action-btns">
                <router-link :to="`/admin/produtos/${product.id}/editar`" class="action-btn">Editar</router-link>
                <button class="action-btn action-btn--danger" @click="deleteProduct(product)">Eliminar</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else class="admin-empty">Nenhum produto encontrado.</p>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination" v-if="lastPage > 1">
      <button :disabled="page <= 1" @click="page--" class="btn btn--outline btn--sm">← Anterior</button>
      <span class="admin-pagination__info">{{ page }} / {{ lastPage }}</span>
      <button :disabled="page >= lastPage" @click="page++" class="btn btn--outline btn--sm">Seguinte →</button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import api from '@/api'

const products = ref([])
const categories = ref([])
const search = ref('')
const categoryFilter = ref('')
const page = ref(1)
const lastPage = ref(1)
const loading = ref(false)

async function fetchProducts() {
  loading.value = true
  try {
    const params = { page: page.value }
    if (search.value) params.search = search.value
    if (categoryFilter.value) params.category_id = categoryFilter.value
    const { data } = await api.admin.products.list(params)
    products.value = data.data
    lastPage.value = data.meta?.last_page || 1
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

async function fetchCategories() {
  try {
    const { data } = await api.admin.categories.list()
    categories.value = data.data || data
  } catch (e) {
    console.error(e)
  }
}

async function deleteProduct(product) {
  if (!confirm(`Eliminar "${product.name}"?`)) return
  try {
    await api.admin.products.delete(product.id)
    fetchProducts()
  } catch (e) {
    console.error(e)
  }
}

let debounceTimer
watch(search, () => { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => { page.value = 1; fetchProducts() }, 400) })
watch(categoryFilter, () => { page.value = 1; fetchProducts() })
watch(page, fetchProducts)

onMounted(() => { fetchProducts(); fetchCategories() })
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: $space-xl; }
.admin-page-title { font-size: $font-size-2xl; font-family: $font-sans; font-weight: 600; margin: 0; }

.admin-filters { display: flex; gap: $space-md; margin-bottom: $space-xl; flex-wrap: wrap; }
.admin-search {
  flex: 1; min-width: 200px; padding: $space-sm $space-lg; border: 1px solid #ddd;
  font-size: $font-size-sm; &:focus { outline: none; border-color: $color-gold; }
}
.admin-select {
  padding: $space-sm $space-lg; border: 1px solid #ddd; font-size: $font-size-sm; background: #fff;
  &:focus { outline: none; border-color: $color-gold; }
}

.admin-card { background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); overflow-x: auto; }
.admin-table {
  width: 100%; border-collapse: collapse;
  th { text-align: left; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .05em; color: $color-warm-gray; padding: $space-md $space-lg; border-bottom: 1px solid #f0f0f0; }
  td { padding: $space-md $space-lg; border-bottom: 1px solid #f8f8f8; font-size: $font-size-sm; vertical-align: middle; }
}

.product-cell { display: flex; align-items: center; gap: $space-md;
  &__thumb { width: 40px; height: 40px; overflow: hidden; background: $color-beige; flex-shrink: 0;
    img { width: 100%; height: 100%; object-fit: cover; }
  }
}

.badge {
  display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
  &--active { background: #e8f5e9; color: #2e7d32; }
  &--inactive { background: #f5f5f5; color: #9e9e9e; }
}

.action-btns { display: flex; gap: $space-sm; }
.action-btn {
  font-size: $font-size-xs; color: $color-gold; background: none; border: none; cursor: pointer; padding: 2px 6px;
  text-decoration: underline; text-underline-offset: 3px;
  &--danger { color: $color-error; }
}

.admin-pagination {
  display: flex; align-items: center; justify-content: center; gap: $space-lg; margin-top: $space-xl;
  &__info { font-size: $font-size-sm; color: $color-warm-gray; }
}

.admin-empty { text-align: center; padding: $space-2xl; color: $color-warm-gray; font-size: $font-size-sm; }
</style>

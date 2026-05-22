<template>
  <div class="catalog-page">
    <!-- Header -->
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Coleção</span>
        <h1 class="page-hero__title">Catálogo</h1>
        <p class="page-hero__text">Peças selecionadas com curadoria para transformar o seu espaço.</p>
      </div>
    </section>

    <!-- Filters -->
    <section class="catalog-filters">
      <div class="container">
        <div class="catalog-filters__inner">
          <button
            class="catalog-filters__btn"
            :class="{ active: !activeCategory }"
            @click="filterByCategory(null)"
          >
            Todos
          </button>
          <button
            v-for="cat in categories"
            :key="cat.id"
            class="catalog-filters__btn"
            :class="{ active: activeCategory === cat.slug }"
            @click="filterByCategory(cat.slug)"
          >
            {{ cat.name }}
          </button>
        </div>
      </div>
    </section>

    <!-- Products Grid -->
    <section class="section">
      <div class="container">
        <div v-if="loading" class="catalog-loading">
          <p>A carregar...</p>
        </div>
        <div v-else-if="products.length === 0" class="catalog-empty">
          <p>Nenhum produto encontrado.</p>
        </div>
        <div v-else class="products-grid">
          <div v-for="product in products" :key="product.id" class="product-card">
            <router-link :to="`/catalogo/${product.slug}`" class="product-card__link">
              <div class="product-card__image">
                <img
                  v-if="product.primary_image?.thumbnail_url"
                  :src="product.primary_image.thumbnail_url"
                  :alt="product.name"
                  loading="lazy"
                  class="img-cover"
                />
                <div v-else class="product-card__placeholder">
                  <span>{{ product.name }}</span>
                </div>
                <div class="product-card__overlay">
                  <span>Ver Detalhes</span>
                </div>
              </div>
              <div class="product-card__info">
                <span class="product-card__category">{{ product.category?.name }}</span>
                <h3 class="product-card__name">{{ product.name }}</h3>
                <p class="product-card__price" v-if="product.formatted_price">{{ product.formatted_price }}</p>
              </div>
            </router-link>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="meta.last_page > 1" class="pagination">
          <button
            v-for="page in meta.last_page"
            :key="page"
            class="pagination__btn"
            :class="{ active: page === meta.current_page }"
            @click="goToPage(page)"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useProductStore } from '@/stores/products'

const route = useRoute()
const router = useRouter()
const store = useProductStore()

const activeCategory = ref(route.query.categoria || null)
const currentPage = ref(Number(route.query.page) || 1)

const products = computed(() => store.products)
const categories = computed(() => store.categories)
const meta = computed(() => store.meta)
const loading = computed(() => store.loading)

function filterByCategory(slug) {
  activeCategory.value = slug
  currentPage.value = 1
  loadProducts()
}

function goToPage(page) {
  currentPage.value = page
  loadProducts()
}

async function loadProducts() {
  const params = { page: currentPage.value }
  if (activeCategory.value) {
    params.category_slug = activeCategory.value
  }
  await store.fetchProducts(params)
  router.replace({
    query: {
      ...(activeCategory.value && { categoria: activeCategory.value }),
      ...(currentPage.value > 1 && { page: currentPage.value }),
    },
  })
}

onMounted(async () => {
  await store.fetchCategories()
  await loadProducts()
})
</script>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-3xl;
  background: url('@/assets/images/saladeestar.jpg') center/cover no-repeat;
  background-color: rgba($color-dark, 0.5);
  background-blend-mode: multiply;
  text-align: center;

  &__subtitle {
    font-family: $font-sans;
    font-size: $font-size-xs;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.4em;
    color: $color-gold;
    display: block;
    margin-bottom: $space-md;
  }
  
  &__title {
    font-family: $font-serif;
    font-size: $font-size-5xl;
    color: $color-ivory;
    margin-bottom: $space-md;
  }
  
  &__text {
    color: $color-sand;
    font-size: $font-size-lg;
    max-width: 500px;
    margin: 0 auto;
  }
}

.catalog-filters {
  padding: $space-xl 0;
  border-bottom: 1px solid $color-beige;
  position: sticky;
  top: $header-height;
  background: $color-ivory;
  z-index: 10;

  &__inner {
    display: flex;
    gap: $space-md;
    overflow-x: auto;
    padding-bottom: $space-xs;

    &::-webkit-scrollbar {
      display: none;
    }
  }

  &__btn {
    padding: $space-sm $space-lg;
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: $color-warm-gray;
    white-space: nowrap;
    transition: all $transition-fast;
    border: 1px solid transparent;

    &:hover {
      color: $color-dark;
    }

    &.active {
      color: $color-dark;
      border-color: $color-dark;
    }
  }
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: $space-2xl;

  @media (max-width: $breakpoint-lg) {
    grid-template-columns: repeat(2, 1fr);
  }

  @media (max-width: $breakpoint-sm) {
    grid-template-columns: 1fr;
  }
}

.product-card {
  &__image {
    position: relative;
    aspect-ratio: 3/4;
    overflow: hidden;
    margin-bottom: $space-md;
    background: $color-cream;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: $color-taupe;
    font-family: $font-serif;
    transition: transform $transition-elegant;
  }

  &__overlay {
    position: absolute;
    inset: 0;
    background: rgba($color-dark, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity $transition-base;

    span {
      font-size: $font-size-xs;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: $color-ivory;
      padding: $space-sm $space-lg;
      border: 1px solid $color-ivory;
    }
  }

  &:hover {
    .product-card__placeholder,
    .product-card__image img {
      transform: scale(1.05);
    }
    .product-card__overlay {
      opacity: 1;
    }
  }

  &__image img {
    transition: transform $transition-elegant;
  }

  &__category {
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: $color-gold;
  }

  &__name {
    font-size: $font-size-lg;
    margin: $space-xs 0;
  }

  &__price {
    font-size: $font-size-sm;
    color: $color-warm-gray;
  }
}

.catalog-loading, .catalog-empty {
  text-align: center;
  padding: $space-4xl 0;
  color: $color-warm-gray;
}

.pagination {
  display: flex;
  justify-content: center;
  gap: $space-sm;
  margin-top: $space-3xl;

  &__btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: $font-size-sm;
    color: $color-warm-gray;
    border: 1px solid $color-beige;
    transition: all $transition-fast;

    &:hover, &.active {
      border-color: $color-dark;
      color: $color-dark;
    }

    &.active {
      background: $color-dark;
      color: $color-ivory;
    }
  }
}
</style>

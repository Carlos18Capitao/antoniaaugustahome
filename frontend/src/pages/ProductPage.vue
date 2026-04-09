<template>
  <div class="product-page" v-if="product">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
      <div class="container">
        <router-link to="/">Início</router-link>
        <span>/</span>
        <router-link to="/catalogo">Catálogo</router-link>
        <span>/</span>
        <span class="breadcrumb__current">{{ product.name }}</span>
      </div>
    </div>

    <!-- Product Detail -->
    <section class="product-detail">
      <div class="container">
        <div class="product-detail__grid">
          <!-- Gallery -->
          <div class="product-gallery">
            <div class="product-gallery__main">
              <img
                v-if="activeImage"
                :src="activeImage"
                :alt="product.name"
                class="img-cover"
                loading="lazy"
              />
              <div v-else class="product-gallery__placeholder">
                <span>{{ product.name }}</span>
              </div>
            </div>
            <div v-if="product.images?.length > 1" class="product-gallery__thumbs">
              <button
                v-for="(img, i) in product.images"
                :key="img.id"
                class="product-gallery__thumb"
                :class="{ active: activeIndex === i }"
                @click="activeIndex = i"
              >
                <img :src="img.thumbnail_url || img.url" :alt="img.alt_text" />
              </button>
            </div>
          </div>

          <!-- Info -->
          <div class="product-info">
            <span class="product-info__category">{{ product.category?.name }}</span>
            <h1 class="product-info__name">{{ product.name }}</h1>
            <div class="divider divider--left"></div>

            <p class="product-info__price" v-if="product.formatted_price">
              {{ product.formatted_price }}
            </p>

            <p class="product-info__short" v-if="product.short_description">
              {{ product.short_description }}
            </p>

            <div class="product-info__description" v-if="product.description" v-html="product.description"></div>

            <!-- Details -->
            <div class="product-details" v-if="product.dimensions || product.materials || product.colors">
              <h4>Detalhes</h4>
              <dl>
                <div v-if="product.dimensions">
                  <dt>Dimensões</dt>
                  <dd>{{ product.dimensions }}</dd>
                </div>
                <div v-if="product.materials">
                  <dt>Materiais</dt>
                  <dd>{{ product.materials }}</dd>
                </div>
                <div v-if="product.colors">
                  <dt>Cores</dt>
                  <dd>{{ product.colors }}</dd>
                </div>
              </dl>
            </div>

            <!-- Availability -->
            <div class="product-info__availability">
              <span :class="product.is_available ? 'available' : 'unavailable'">
                {{ product.is_available ? 'Disponível' : 'Sob Consulta' }}
              </span>
            </div>

            <!-- CTA -->
            <div class="product-info__actions">
              <a :href="whatsappUrl" target="_blank" rel="noopener noreferrer" class="btn btn--primary btn--lg">
                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Pedir Informação
              </a>
              <router-link to="/contacto" class="btn btn--outline btn--lg">Contactar</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Related Products -->
    <section class="section section--cream" v-if="relatedProducts.length">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Também poderá gostar</span>
          <h2 class="section-header__title">Produtos Relacionados</h2>
        </div>
        <div class="related-grid">
          <div v-for="item in relatedProducts" :key="item.id" class="product-card">
            <router-link :to="`/catalogo/${item.slug}`" class="product-card__link">
              <div class="product-card__image">
                <img v-if="item.primary_image?.thumbnail_url" :src="item.primary_image.thumbnail_url" :alt="item.name" loading="lazy" class="img-cover" />
                <div v-else class="product-card__placeholder"><span>{{ item.name }}</span></div>
              </div>
              <div class="product-card__info">
                <h3 class="product-card__name">{{ item.name }}</h3>
                <p class="product-card__price" v-if="item.formatted_price">{{ item.formatted_price }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div v-else-if="loading" class="page-loading"><p>A carregar...</p></div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useProductStore } from '@/stores/products'

const route = useRoute()
const store = useProductStore()

const activeIndex = ref(0)

const product = computed(() => store.product)
const relatedProducts = computed(() => store.relatedProducts)
const loading = computed(() => store.loading)

const activeImage = computed(() => {
  if (!product.value?.images?.length) return null
  return product.value.images[activeIndex.value]?.url
})

const whatsappUrl = computed(() => {
  const msg = `Olá! Estou interessado(a) no produto: ${product.value?.name}`
  return `https://wa.me/351XXXXXXXXX?text=${encodeURIComponent(msg)}`
})

async function loadProduct() {
  activeIndex.value = 0
  await store.fetchProduct(route.params.slug)
  await store.fetchRelated(route.params.slug)
}

onMounted(loadProduct)
watch(() => route.params.slug, loadProduct)
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.breadcrumb {
  padding: calc(#{$header-height} + #{$space-lg}) 0 $space-lg;
  background: $color-cream;

  a, span { font-size: $font-size-xs; color: $color-warm-gray; text-transform: uppercase; letter-spacing: 0.1em; }
  a:hover { color: $color-dark; }
  &__current { color: $color-dark; }
  span { margin: 0 $space-sm; }
}

.product-detail {
  padding: $space-3xl 0 $space-5xl;

  &__grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: $space-4xl;

    @media (max-width: $breakpoint-lg) {
      grid-template-columns: 1fr;
      gap: $space-2xl;
    }
  }
}

.product-gallery {
  &__main {
    aspect-ratio: 4/5;
    background: $color-cream;
    overflow: hidden;
    margin-bottom: $space-md;

    img { width: 100%; height: 100%; object-fit: cover; }
  }

  &__placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: $color-taupe; font-family: $font-serif; font-size: $font-size-xl;
  }

  &__thumbs {
    display: flex; gap: $space-sm;
  }

  &__thumb {
    width: 80px; height: 80px; overflow: hidden; border: 2px solid transparent;
    transition: border-color $transition-fast; cursor: pointer; padding: 0;

    &.active, &:hover { border-color: $color-gold; }
    img { width: 100%; height: 100%; object-fit: cover; }
  }
}

.product-info {
  &__category {
    font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.2em; color: $color-gold;
  }

  &__name {
    font-size: $font-size-4xl; margin: $space-sm 0 0;
    @media (max-width: $breakpoint-sm) { font-size: $font-size-3xl; }
  }

  &__price {
    font-size: $font-size-2xl; font-family: $font-sans; font-weight: 300;
    color: $color-charcoal; margin: $space-lg 0;
  }

  &__short {
    font-size: $font-size-lg; color: $color-warm-gray; line-height: 1.8; margin-bottom: $space-lg;
  }

  &__description {
    color: $color-charcoal; line-height: 1.9; margin-bottom: $space-2xl;
    p { margin-bottom: $space-md; }
  }

  &__availability {
    margin-bottom: $space-2xl;
    .available { color: $color-success; font-size: $font-size-sm; font-weight: 500; }
    .unavailable { color: $color-gold; font-size: $font-size-sm; font-weight: 500; }
  }

  &__actions {
    display: flex; gap: $space-lg; flex-wrap: wrap;
    .btn { display: inline-flex; align-items: center; gap: $space-sm; }
  }
}

.product-details {
  margin-bottom: $space-2xl; padding: $space-xl; background: $color-cream;

  h4 { font-family: $font-sans; font-size: $font-size-xs; text-transform: uppercase;
       letter-spacing: 0.15em; margin-bottom: $space-md; color: $color-dark; }

  dl > div {
    display: flex; padding: $space-sm 0; border-bottom: 1px solid $color-beige;
    &:last-child { border: none; }
  }

  dt { font-weight: 500; font-size: $font-size-sm; width: 120px; color: $color-charcoal; }
  dd { font-size: $font-size-sm; color: $color-warm-gray; }
}

.related-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: repeat(2, 1fr); }
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.product-card {
  &__image { aspect-ratio: 3/4; overflow: hidden; margin-bottom: $space-md; background: $color-beige; }
  &__placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    color: $color-taupe; font-family: $font-serif; transition: transform $transition-elegant;
  }
  &:hover .product-card__placeholder { transform: scale(1.05); }
  &__name { font-size: $font-size-base; }
  &__price { font-size: $font-size-sm; color: $color-warm-gray; }
}

.page-loading { min-height: 60vh; display: flex; align-items: center; justify-content: center; color: $color-warm-gray; }
</style>

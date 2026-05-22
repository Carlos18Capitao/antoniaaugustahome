<template>
  <div>
    <!-- HERO SECTION -->
    <section class="hero">
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <span class="hero__subtitle">Decoração de Interiores Premium</span>
        <h1 class="hero__title">A Arte de<br>Viver com Elegância</h1>
        <div class="divider"></div>
        <p class="hero__text">Transformamos espaços em experiências únicas de sofisticação e conforto.</p>
        <div class="hero__actions">
          <router-link to="/catalogo" class="btn btn--white btn--lg">Explorar Catálogo</router-link>
          <router-link to="/projetos" class="btn btn--outline btn--lg hero__btn-outline">Nossos Projetos</router-link>
        </div>
      </div>
      <div class="hero__scroll">
        <span>Scroll</span>
        <div class="hero__scroll-line"></div>
      </div>
    </section>

    <!-- INTRO SECTION -->
    <section class="section intro">
      <div class="container">
        <div class="intro__grid">
          <div class="intro__image">
            <img :src="introImg" alt="Interior Premium" class="intro__image-photo" />
          </div>
          <div class="intro__content">
            <span class="section-header__subtitle">Sobre Nós</span>
            <h2>Onde o Design<br>Encontra a Alma</h2>
            <div class="divider divider--left"></div>
            <p>Na Antônio Augusta Home, cada peça conta uma história. Selecionamos cuidadosamente mobiliário e acessórios de decoração que transformam casas em verdadeiros refúgios de elegância.</p>
            <p>Com curadoria rigorosa e atenção meticulosa ao detalhe, criamos ambientes que refletem a personalidade e o estilo de vida dos nossos clientes.</p>
            <router-link to="/sobre" class="btn btn--primary">Conheça-nos</router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="section section--cream">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Curadoria</span>
          <h2 class="section-header__title">Peças em Destaque</h2>
          <p class="section-header__description">Uma seleção exclusiva das nossas peças mais emblemáticas.</p>
        </div>
        <div class="products-grid">
          <div v-for="product in featuredProducts" :key="product.id" class="product-card">
            <router-link :to="`/catalogo/${product.slug}`" class="product-card__link">
              <div class="product-card__image">
                <img
                  v-if="product.primary_image?.url"
                  :src="product.primary_image.url"
                  :alt="product.primary_image.alt_text || product.name"
                  class="product-card__photo"
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
        <div class="section-cta">
          <router-link to="/catalogo" class="btn btn--primary btn--lg">Ver Todo o Catálogo</router-link>
        </div>
      </div>
    </section>

    <!-- STORYTELLING BAND -->
    <section class="band">
      <div class="band__overlay"></div>
      <div class="band__content">
        <span class="band__subtitle">Filosofia</span>
        <h2 class="band__title">"O luxo verdadeiro é sentir-se em casa<br>num espaço que inspira."</h2>
      </div>
    </section>

    <!-- FEATURED PROJECTS -->
    <section class="section">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Portfólio</span>
          <h2 class="section-header__title">Projetos de Inspiração</h2>
          <p class="section-header__description">Espaços que transformámos em obras de arte habitáveis.</p>
        </div>
        <div class="projects-grid">
          <div v-for="project in featuredProjects" :key="project.id" class="project-card">
            <router-link :to="`/projetos/${project.slug}`" class="project-card__link">
              <div class="project-card__image">
                <div class="project-card__placeholder">
                  <span>{{ project.title }}</span>
                </div>
                <div class="project-card__info">
                  <span class="project-card__location">{{ project.location }}</span>
                  <h3 class="project-card__title">{{ project.title }}</h3>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div class="section-cta">
          <router-link to="/projetos" class="btn btn--outline btn--lg">Ver Todos os Projetos</router-link>
        </div>
      </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-section__inner">
          <span class="section-header__subtitle">Vamos Conversar</span>
          <h2>Pronto para Transformar<br>o Seu Espaço?</h2>
          <div class="divider"></div>
          <p>Entre em contacto connosco e descubra como podemos criar o ambiente perfeito para si.</p>
          <div class="cta-section__actions">
            <router-link to="/contacto" class="btn btn--gold btn--lg">Contacte-nos</router-link>
            <a :href="whatsappUrl" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--lg">
              WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useProductStore } from '@/stores/products'
import { useProjectStore } from '@/stores/projects'
import introImg from '@/assets/images/intro-image.jpeg'

const productStore = useProductStore()
const projectStore = useProjectStore()

const featuredProducts = computed(() => productStore.featuredProducts)
const featuredProjects = computed(() => projectStore.featuredProjects)

const whatsappUrl = computed(() => {
  return `https://wa.me/244941708763?text=${encodeURIComponent('Olá! Gostaria de saber mais sobre os vossos produtos.')}`
})

onMounted(async () => {
  await Promise.all([
    productStore.fetchFeatured(),
    projectStore.fetchFeatured(),
  ])
})
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

// HERO
.hero {
  position: relative;
  height: 100vh;
  min-height: 700px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: $color-dark url('@/assets/images/saladeestar.jpg') center/cover no-repeat;
  overflow: hidden;

  &__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
      135deg,
      rgba($color-dark, 0.85) 0%,
      rgba($color-dark, 0.6) 50%,
      rgba($color-dark, 0.75) 100%
    );
    z-index: 1;
  }

  &__content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 0 $space-xl;
    max-width: 900px;
  }

  &__subtitle {
    font-family: $font-sans;
    font-size: $font-size-xs;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.4em;
    color: $color-gold;
    display: block;
    margin-bottom: $space-xl;
  }

  &__title {
    font-family: $font-serif;
    font-size: $font-size-hero;
    font-weight: 300;
    color: $color-ivory;
    line-height: 1.1;
    margin-bottom: $space-lg;

    @media (max-width: $breakpoint-lg) {
      font-size: $font-size-5xl;
    }

    @media (max-width: $breakpoint-sm) {
      font-size: $font-size-4xl;
    }
  }

  &__text {
    font-size: $font-size-lg;
    color: $color-sand;
    max-width: 500px;
    margin: 0 auto $space-2xl;
    line-height: 1.8;
  }

  &__actions {
    display: flex;
    gap: $space-lg;
    justify-content: center;
    flex-wrap: wrap;
  }

  &__btn-outline {
    border-color: rgba(255, 255, 255, 0.3) !important;
    color: $color-ivory !important;

    &:hover {
      background: rgba(255, 255, 255, 0.1) !important;
    }
  }

  .divider {
    background-color: $color-gold;
    margin-bottom: $space-xl;
  }

  &__scroll {
    position: absolute;
    bottom: $space-2xl;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: $space-sm;

    span {
      font-size: $font-size-xs;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: $color-sand;
    }

    &-line {
      width: 1px;
      height: 40px;
      background: $color-gold;
      animation: scrollLine 2s ease-in-out infinite;
    }
  }
}

@keyframes scrollLine {
  0%, 100% { opacity: 0.3; transform: scaleY(0.5); }
  50% { opacity: 1; transform: scaleY(1); }
}

// INTRO
.intro {
  &__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: $space-4xl;
    align-items: center;

    @media (max-width: $breakpoint-md) {
      grid-template-columns: 1fr;
      gap: $space-2xl;
    }
  }

  &__image {
    aspect-ratio: 4/5;
    overflow: hidden;
  }

  &__image-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__content {
    h2 {
      margin-bottom: $space-sm;
    }

    p {
      color: $color-warm-gray;
      margin-bottom: $space-lg;
      line-height: 1.9;
    }

    .btn {
      margin-top: $space-lg;
    }
  }
}

// PRODUCTS GRID
.products-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: $space-xl;
  margin-bottom: $space-3xl;

  @media (max-width: $breakpoint-lg) {
    grid-template-columns: repeat(2, 1fr);
  }

  @media (max-width: $breakpoint-sm) {
    grid-template-columns: 1fr;
  }
}

.product-card {
  &__link {
    display: block;
  }

  &__image {
    position: relative;
    aspect-ratio: 3/4;
    overflow: hidden;
    margin-bottom: $space-md;
  }

  &__photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform $transition-elegant;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    background: $color-beige;
    display: flex;
    align-items: center;
    justify-content: center;
    color: $color-warm-gray;
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
    .product-card__photo {
      transform: scale(1.05);
    }

    .product-card__overlay {
      opacity: 1;
    }
  }

  &__category {
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: $color-gold;
  }

  &__name {
    font-size: $font-size-lg;
    font-weight: 400;
    margin: $space-xs 0;
  }

  &__price {
    font-family: $font-sans;
    font-size: $font-size-sm;
    color: $color-warm-gray;
  }
}

// STORYTELLING BAND
.band {
  position: relative;
  padding: $space-6xl $space-xl;
  background: $color-dark;
  text-align: center;

  &__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(rgba($color-dark, 0.8), rgba($color-dark, 0.8));
  }

  &__content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 0 auto;
  }

  &__subtitle {
    font-family: $font-sans;
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.4em;
    color: $color-gold;
    display: block;
    margin-bottom: $space-xl;
  }

  &__title {
    font-family: $font-serif;
    font-size: $font-size-4xl;
    font-weight: 300;
    font-style: italic;
    color: $color-ivory;
    line-height: 1.4;

    @media (max-width: $breakpoint-sm) {
      font-size: $font-size-2xl;
    }
  }
}

// PROJECTS GRID
.projects-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: $space-xl;
  margin-bottom: $space-3xl;

  @media (max-width: $breakpoint-md) {
    grid-template-columns: 1fr;
  }
}

.project-card {
  &__image {
    position: relative;
    aspect-ratio: 16/10;
    overflow: hidden;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    background: $color-beige;
    display: flex;
    align-items: center;
    justify-content: center;
    color: $color-warm-gray;
    font-family: $font-serif;
    transition: transform $transition-elegant;
  }

  &__info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: $space-xl;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: $color-ivory;
  }

  &__location {
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: $color-gold-light;
  }

  &__title {
    font-size: $font-size-xl;
    color: $color-ivory;
    margin-top: $space-xs;
  }

  &:hover .project-card__placeholder {
    transform: scale(1.05);
  }
}

// CTA SECTION
.cta-section {
  padding: $space-5xl 0;
  background: $color-cream;

  &__inner {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;

    h2 {
      margin-bottom: 0;
    }

    p {
      color: $color-warm-gray;
      font-size: $font-size-lg;
      line-height: 1.8;
      margin-bottom: $space-2xl;
    }
  }

  &__actions {
    display: flex;
    gap: $space-lg;
    justify-content: center;
    flex-wrap: wrap;
  }
}

.section-cta {
  text-align: center;
}
</style>

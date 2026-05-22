<template>
  <div class="project-detail" v-if="project">
    <!-- Hero -->
    <section class="project-hero">
      <img v-if="project.cover_image" :src="project.cover_image" :alt="project.title" class="project-hero__bg" />
      <div class="project-hero__overlay">
        <div class="container">
          <span class="project-hero__location" v-if="project.location">{{ project.location }}</span>
          <h1 class="project-hero__title">{{ project.title }}</h1>
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="section">
      <div class="container">
        <div class="project-content">
          <div class="project-content__description" v-if="project.description" v-html="project.description"></div>

          <div class="project-meta" v-if="project.client_name || project.completed_at">
            <div v-if="project.client_name" class="project-meta__item">
              <span class="project-meta__label">Cliente</span>
              <span class="project-meta__value">{{ project.client_name }}</span>
            </div>
            <div v-if="project.location" class="project-meta__item">
              <span class="project-meta__label">Localização</span>
              <span class="project-meta__value">{{ project.location }}</span>
            </div>
            <div v-if="project.completed_at" class="project-meta__item">
              <span class="project-meta__label">Conclusão</span>
              <span class="project-meta__value">{{ project.completed_at }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery -->
    <section class="section section--cream" v-if="project.images?.length">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Galeria</span>
          <h2 class="section-header__title">Imagens do Projeto</h2>
        </div>
        <div class="project-gallery">
          <div
            v-for="(img, i) in project.images"
            :key="img.id"
            class="project-gallery__item"
            @click="openLightbox(i)"
          >
            <img :src="img.thumbnail_url || img.url" :alt="img.alt_text" loading="lazy" class="img-cover" />
          </div>
        </div>
      </div>
    </section>

    <!-- Lightbox -->
    <Teleport to="body">
      <div v-if="lightboxOpen" class="lightbox" @click.self="closeLightbox">
        <button class="lightbox__close" @click="closeLightbox">&times;</button>
        <button class="lightbox__prev" @click="prevImage">&lsaquo;</button>
        <div class="lightbox__content">
          <img :src="project.images[lightboxIndex]?.url" :alt="project.images[lightboxIndex]?.alt_text" />
        </div>
        <button class="lightbox__next" @click="nextImage">&rsaquo;</button>
      </div>
    </Teleport>

    <!-- CTA -->
    <section class="section">
      <div class="container text-center">
        <span class="section-header__subtitle">Inspirado?</span>
        <h2 class="section-header__title">Vamos Criar o Seu Espaço</h2>
        <p class="section-text">Entre em contacto connosco e transforme a sua visão em realidade.</p>
        <div class="cta-actions">
          <router-link to="/contacto" class="btn btn--primary btn--lg">Contacte-nos</router-link>
          <router-link to="/projetos" class="btn btn--outline btn--lg">Ver Mais Projetos</router-link>
        </div>
      </div>
    </section>
  </div>
  <div v-else-if="loading" class="page-loading"><p>A carregar...</p></div>
</template>

<script setup>
import { ref, computed, onMounted, watch, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useProjectStore } from '@/stores/projects'

const route = useRoute()
const store = useProjectStore()

const project = computed(() => store.project)
const loading = computed(() => store.loading)

const lightboxOpen = ref(false)
const lightboxIndex = ref(0)

function openLightbox(i) { lightboxIndex.value = i; lightboxOpen.value = true; document.body.style.overflow = 'hidden' }
function closeLightbox() { lightboxOpen.value = false; document.body.style.overflow = '' }
function nextImage() { if (project.value?.images) lightboxIndex.value = (lightboxIndex.value + 1) % project.value.images.length }
function prevImage() { if (project.value?.images) lightboxIndex.value = (lightboxIndex.value - 1 + project.value.images.length) % project.value.images.length }

function onKeydown(e) {
  if (!lightboxOpen.value) return
  if (e.key === 'Escape') closeLightbox()
  if (e.key === 'ArrowRight') nextImage()
  if (e.key === 'ArrowLeft') prevImage()
}

onMounted(() => {
  store.fetchProject(route.params.slug)
  document.addEventListener('keydown', onKeydown)
})
onUnmounted(() => {
  document.removeEventListener('keydown', onKeydown)
  document.body.style.overflow = ''
})
watch(() => route.params.slug, (slug) => slug && store.fetchProject(slug))
</script>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

.project-hero {
  position: relative; height: 70vh; min-height: 500px; background: $color-dark;

  &__bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: .7; }
  &__overlay {
    position: relative; z-index: 1; display: flex; align-items: flex-end;
    height: 100%; padding-bottom: $space-4xl;
  }
  &__location {
    display: block; font-size: $font-size-xs; text-transform: uppercase;
    letter-spacing: 0.3em; color: $color-gold; margin-bottom: $space-sm;
  }
  &__title { font-size: $font-size-5xl; color: #fff; margin: 0; }
}

.project-content {
  max-width: 800px; margin: 0 auto;

  &__description { line-height: 2; color: $color-charcoal; font-size: $font-size-lg; margin-bottom: $space-3xl;
    :deep(p) { margin-bottom: $space-lg; }
  }
}

.project-meta {
  display: flex; flex-wrap: wrap; gap: $space-3xl; padding: $space-2xl 0; border-top: 1px solid $color-beige;

  &__label { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.15em; color: $color-gold; margin-bottom: $space-xs; }
  &__value { font-family: $font-serif; font-size: $font-size-lg; }
}

.project-gallery {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: $space-lg;

  @media (max-width: $breakpoint-lg) { grid-template-columns: repeat(2, 1fr); }
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }

  &__item {
    aspect-ratio: 4/3; overflow: hidden; cursor: pointer; background: $color-beige;
    img { transition: transform $transition-elegant; width: 100%; height: 100%; object-fit: cover; }
    &:hover img { transform: scale(1.05); }
  }
}

.lightbox {
  position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.95);
  display: flex; align-items: center; justify-content: center;

  &__close {
    position: absolute; top: $space-xl; right: $space-xl; color: #fff;
    font-size: 2.5rem; background: none; border: none; cursor: pointer; z-index: 2;
  }
  &__prev, &__next {
    position: absolute; top: 50%; transform: translateY(-50%);
    color: #fff; font-size: 3rem; background: none; border: none; cursor: pointer; z-index: 2;
    padding: $space-lg;
  }
  &__prev { left: $space-xl; }
  &__next { right: $space-xl; }

  &__content {
    max-width: 90vw; max-height: 90vh;
    img { max-width: 100%; max-height: 90vh; object-fit: contain; }
  }
}

.section-text { color: $color-warm-gray; max-width: 500px; margin: $space-lg auto $space-2xl; line-height: 1.8; }
.cta-actions { display: flex; gap: $space-lg; justify-content: center; flex-wrap: wrap; }
.page-loading { min-height: 60vh; display: flex; align-items: center; justify-content: center; color: $color-warm-gray; }
</style>

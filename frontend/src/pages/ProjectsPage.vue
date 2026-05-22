<template>
  <div class="projects-page">
    <!-- Hero -->
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Portfólio</span>
        <h1 class="page-hero__title">Os Nossos Projetos</h1>
        <div class="divider divider--center"></div>
        <p class="page-hero__text">Espaços únicos criados com paixão, onde cada detalhe reflete a personalidade de quem os habita.</p>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="section">
      <div class="container">
        <div class="projects-grid" v-if="projects.length">
          <article v-for="project in projects" :key="project.id" class="project-card" :class="{ 'project-card--featured': project.is_featured }">
            <router-link :to="`/projetos/${project.slug}`" class="project-card__link">
              <div class="project-card__image">
                <img v-if="project.cover_image" :src="project.cover_image" :alt="project.title" loading="lazy" class="img-cover" />
                <div v-else class="project-card__placeholder">
                  <span>{{ project.title }}</span>
                </div>
                <div class="project-card__overlay">
                  <span class="project-card__cta">Ver Projeto</span>
                </div>
              </div>
              <div class="project-card__info">
                <h2 class="project-card__title">{{ project.title }}</h2>
                <p class="project-card__location" v-if="project.location">{{ project.location }}</p>
              </div>
            </router-link>
          </article>
        </div>

        <div v-else-if="loading" class="page-loading">
          <p>A carregar projetos...</p>
        </div>

        <div v-else class="empty-state">
          <p>De momento não existem projetos publicados.</p>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section section--dark">
      <div class="container text-center">
        <span class="section-header__subtitle" style="color: var(--color-gold);">Vamos Criar Juntos</span>
        <h2 class="section-header__title" style="color: #fff;">O Seu Próximo Espaço de Sonho</h2>
        <p style="color: rgba(255,255,255,.7); max-width: 600px; margin: 1.5rem auto 2.5rem; line-height: 1.8;">
          Cada projeto é uma história única. Conte-nos a sua visão e transformamos o seu espaço num lugar extraordinário.
        </p>
        <router-link to="/contacto" class="btn btn--gold btn--lg">Fale Connosco</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useProjectStore } from '@/stores/projects'

const store = useProjectStore()
const projects = computed(() => store.projects)
const loading = computed(() => store.loading)

onMounted(() => store.fetchProjects())
</script>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-4xl;
  background: $color-dark url('@/assets/images/side-view-man-working-project.webp') center/cover no-repeat;
  text-align: center;

  &__subtitle {
    font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.3em; color: $color-gold;
    display: block; margin-bottom: $space-md;
  }
  &__title { font-size: $font-size-5xl; margin-bottom: 0; color: $color-ivory; }
  &__text { max-width: 600px; margin: $space-xl auto 0; color: $color-sand; line-height: 1.8; font-size: $font-size-lg; }
}

.projects-grid {
  display: grid; grid-template-columns: repeat(2, 1fr); gap: $space-2xl;

  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.project-card {
  &--featured { grid-column: span 2; @media (max-width: $breakpoint-sm) { grid-column: span 1; } }

  &__link { display: block; text-decoration: none; color: inherit; }

  &__image {
    position: relative; overflow: hidden; aspect-ratio: 16/10;
    background: $color-beige;

    .project-card--featured & { aspect-ratio: 21/9; }
    @media (max-width: $breakpoint-sm) { aspect-ratio: 4/3 !important; }

    img { transition: transform $transition-elegant; }
    &:hover img { transform: scale(1.05); }
  }

  &__placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    font-family: $font-serif; font-size: $font-size-xl; color: $color-taupe;
  }

  &__overlay {
    position: absolute; inset: 0; background: rgba(0,0,0,.3);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity $transition-fast;
  }
  &__link:hover &__overlay { opacity: 1; }

  &__cta {
    color: #fff; font-size: $font-size-xs; text-transform: uppercase;
    letter-spacing: 0.2em; border: 1px solid rgba(255,255,255,.6);
    padding: $space-sm $space-xl;
  }

  &__info { padding: $space-lg 0; }
  &__title { font-size: $font-size-2xl; margin-bottom: $space-xs; }
  &__location { font-size: $font-size-sm; color: $color-warm-gray; text-transform: uppercase; letter-spacing: 0.1em; }
}

.empty-state { text-align: center; padding: $space-5xl 0; color: $color-warm-gray; }
.page-loading { text-align: center; padding: $space-5xl 0; color: $color-warm-gray; }
</style>

<template>
  <div class="contact-page">
    <!-- Hero -->
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Fale Connosco</span>
        <h1 class="page-hero__title">Contacto</h1>
        <div class="divider divider--center"></div>
        <p class="page-hero__text">Estamos disponíveis para o ajudar a criar o espaço dos seus sonhos.</p>
      </div>
    </section>

    <!-- Contact Content -->
    <section class="section">
      <div class="container">
        <div class="contact-main">
          <!-- Cards de contacto -->
          <div class="contact-cards">
            <a :href="whatsappUrl" target="_blank" rel="noopener noreferrer" class="contact-card contact-card--highlight">
              <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
              </div>
              <div class="contact-card__body">
                <strong>WhatsApp</strong>
                <span>+244 941 708 763</span>
                <em>Resposta rápida</em>
              </div>
            </a>

            <a href="tel:+244941708763" class="contact-card">
              <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
              </div>
              <div class="contact-card__body">
                <strong>Telefone</strong>
                <span>+244 941 708 763</span>
                <em>Seg–Sex 09h–17h</em>
              </div>
            </a>

            <a href="mailto:info@antonioaugustahome.pt" class="contact-card">
              <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
              </div>
              <div class="contact-card__body">
                <strong>Email</strong>
                <span>info@antonioaugustahome.pt</span>
              </div>
            </a>

            <div class="contact-card">
              <div class="contact-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
              </div>
              <div class="contact-card__body">
                <strong>Showroom</strong>
                <span>Bela Business Park, <br>Luanda, Angola</span>
                <em>Seg–Sex 09h–17h</em>
              </div>
            </div>
          </div>

          <!-- Info adicional -->
          <div class="contact-social">
            <h4>Siga-nos</h4>
            <div class="contact-social__links">
              <a href="https://www.instagram.com/antonioaugustahome?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer">Instagram</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const whatsappUrl = computed(() =>
  `https://wa.me/244941708763?text=${encodeURIComponent('Olá! Gostaria de obter mais informações.')}`
)
</script>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-4xl;
  background: $color-cream; text-align: center;

  &__subtitle { font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.3em; color: $color-gold; display: block; margin-bottom: $space-md; }
  &__title { font-size: $font-size-5xl; margin-bottom: 0; }
  &__text { max-width: 500px; margin: $space-xl auto 0; color: $color-warm-gray; line-height: 1.8; }
}

.contact-main {
  max-width: 860px;
  margin: 0 auto;
}

.contact-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: $space-xl;
  margin-bottom: $space-3xl;

  @media (max-width: $breakpoint-sm) {
    grid-template-columns: 1fr;
  }
}

.contact-card {
  display: flex;
  align-items: flex-start;
  gap: $space-lg;
  padding: $space-2xl;
  background: $color-cream;
  text-decoration: none;
  color: inherit;
  transition: background $transition-fast;

  &:hover { background: $color-beige; }

  &--highlight {
    background: $color-dark;
    color: $color-ivory;

    &:hover { background: $color-charcoal; }

    .contact-card__icon { color: $color-gold; }
    .contact-card__body strong { color: $color-gold; }
    .contact-card__body span { color: $color-ivory; }
    .contact-card__body em { color: $color-sand; }
  }

  &__icon {
    color: $color-gold;
    flex-shrink: 0;
    margin-top: 2px;
  }

  &__body {
    display: flex;
    flex-direction: column;
    gap: $space-xs;

    strong {
      font-size: $font-size-xs;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: $color-gold;
      font-weight: 500;
    }

    span {
      font-size: $font-size-base;
      color: $color-charcoal;
      line-height: 1.6;
    }

    em {
      font-style: normal;
      font-size: $font-size-xs;
      color: $color-warm-gray;
    }
  }
}

.contact-social {
  text-align: center;

  h4 {
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: $space-md;
    color: $color-warm-gray;
  }

  &__links {
    display: flex;
    justify-content: center;
    gap: $space-lg;

    a {
      color: $color-charcoal;
      font-size: $font-size-sm;
      text-decoration: underline;
      text-underline-offset: 3px;

      &:hover { color: $color-gold; }
    }
  }
}
</style>

<template>
  <footer class="footer">
    <div class="container">
      <div class="footer__top">
        <div class="footer__brand">
          <div class="footer__logo">
            <span class="footer__logo-text">Antônio Augusta</span>
            <span class="footer__logo-sub">HOME</span>
          </div>
          <p class="footer__tagline">
            Sofisticação, exclusividade e conforto.<br>
            Transformamos espaços em experiências.
          </p>
        </div>

        <div class="footer__links">
          <div class="footer__col">
            <h4>Navegação</h4>
            <router-link to="/">Início</router-link>
            <router-link to="/catalogo">Catálogo</router-link>
            <router-link to="/projetos">Projetos</router-link>
            <router-link to="/sobre">Sobre Nós</router-link>
            <router-link to="/contacto">Contacto</router-link>
          </div>

          <div class="footer__col">
            <h4>Contacto</h4>
            <a href="tel:+351XXXXXXXXX">+351 XXX XXX XXX</a>
            <a href="mailto:contato@antonioaugustahome.pt">contato@antonioaugustahome.pt</a>
            <p>Lisboa, Portugal</p>
          </div>

          <div class="footer__col">
            <h4>Horário</h4>
            <p>Segunda - Sexta: 10h - 19h</p>
            <p>Sábado: 10h - 14h</p>
            <p>Domingo: Fechado</p>
          </div>
        </div>
      </div>

      <div class="footer__bottom">
        <p>&copy; {{ currentYear }} Antônio Augusta Home. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear()
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.footer {
  background-color: $color-dark;
  color: $color-sand;
  padding: $space-4xl 0 $space-xl;

  &__top {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: $space-4xl;
    padding-bottom: $space-3xl;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);

    @media (max-width: $breakpoint-md) {
      grid-template-columns: 1fr;
      gap: $space-2xl;
    }
  }

  &__logo {
    display: flex;
    flex-direction: column;
    line-height: 1;
    margin-bottom: $space-lg;

    &-text {
      font-family: $font-serif;
      font-size: $font-size-xl;
      font-weight: 500;
      color: $color-ivory;
    }

    &-sub {
      font-family: $font-sans;
      font-size: $font-size-xs;
      font-weight: 300;
      letter-spacing: 0.4em;
      color: $color-gold;
      margin-top: 2px;
    }
  }

  &__tagline {
    font-size: $font-size-sm;
    line-height: 1.8;
    color: $color-taupe;
  }

  &__links {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: $space-2xl;

    @media (max-width: $breakpoint-sm) {
      grid-template-columns: 1fr;
    }
  }

  &__col {
    h4 {
      font-family: $font-sans;
      font-size: $font-size-xs;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: $color-gold;
      margin-bottom: $space-lg;
    }

    a, p {
      display: block;
      font-size: $font-size-sm;
      color: $color-taupe;
      margin-bottom: $space-sm;
      transition: color $transition-fast;
    }

    a:hover {
      color: $color-ivory;
    }
  }

  &__bottom {
    padding-top: $space-xl;
    text-align: center;

    p {
      font-size: $font-size-xs;
      color: $color-warm-gray;
      letter-spacing: 0.05em;
    }
  }
}
</style>

<template>
  <Transition name="cookie-slide">
    <div v-if="isVisible" class="cookie-banner">
      <div class="cookie-banner__content">
        <p>
          Utilizamos cookies para melhorar a sua experiência de navegação e analisar o tráfego do site.
          Ao continuar a navegar, concorda com a nossa
          <router-link to="/politica-privacidade">Política de Privacidade</router-link>.
        </p>
        <div class="cookie-banner__actions">
          <button class="cookie-banner__btn cookie-banner__btn--reject" @click="rejectCookies">
            Rejeitar
          </button>
          <button class="cookie-banner__btn cookie-banner__btn--accept" @click="acceptCookies">
            Aceitar Cookies
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const COOKIE_CONSENT_KEY = 'aa_cookie_consent'
const isVisible = ref(false)

onMounted(() => {
  const consent = localStorage.getItem(COOKIE_CONSENT_KEY)
  if (!consent) {
    isVisible.value = true
  }
})

function acceptCookies() {
  localStorage.setItem(COOKIE_CONSENT_KEY, 'accepted')
  isVisible.value = false
}

function rejectCookies() {
  localStorage.setItem(COOKIE_CONSENT_KEY, 'rejected')
  isVisible.value = false
}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.cookie-banner {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 9999;
  background: $color-dark;
  border-top: 1px solid rgba($color-gold, 0.3);
  padding: $space-lg $space-xl;

  &__content {
    max-width: $max-width;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: $space-xl;

    @media (max-width: $breakpoint-md) {
      flex-direction: column;
      text-align: center;
    }

    p {
      color: $color-sand;
      font-size: $font-size-sm;
      line-height: 1.7;
      margin: 0;

      a {
        color: $color-gold;
        text-decoration: underline;
        transition: color $transition-fast;

        &:hover {
          color: $color-gold-light;
        }
      }
    }
  }

  &__actions {
    display: flex;
    gap: $space-md;
    flex-shrink: 0;
  }

  &__btn {
    padding: $space-sm $space-xl;
    font-family: $font-sans;
    font-size: $font-size-sm;
    font-weight: 500;
    letter-spacing: 0.05em;
    border: none;
    cursor: pointer;
    transition: all $transition-fast;
    white-space: nowrap;

    &--accept {
      background: $color-gold;
      color: $color-dark;

      &:hover {
        background: $color-gold-light;
      }
    }

    &--reject {
      background: transparent;
      color: $color-taupe;
      border: 1px solid $color-warm-gray;

      &:hover {
        color: $color-ivory;
        border-color: $color-ivory;
      }
    }
  }
}

.cookie-slide-enter-active,
.cookie-slide-leave-active {
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
}

.cookie-slide-enter-from,
.cookie-slide-leave-to {
  transform: translateY(100%);
  opacity: 0;
}
</style>

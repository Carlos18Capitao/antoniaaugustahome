<template>
  <header class="header" :class="{ 'header--scrolled': isScrolled, 'header--open': menuOpen }">
    <div class="container header__inner">
      <router-link to="/" class="header__logo" @click="menuOpen = false">
        <span class="header__logo-text">Antônio Augusta</span>
        <span class="header__logo-sub">HOME</span>
      </router-link>

      <nav class="header__nav" :class="{ 'is-open': menuOpen }">
        <router-link to="/" @click="menuOpen = false">Início</router-link>
        <router-link to="/catalogo" @click="menuOpen = false">Catálogo</router-link>
        <router-link to="/projetos" @click="menuOpen = false">Projetos</router-link>
        <router-link to="/sobre" @click="menuOpen = false">Sobre</router-link>
        <router-link to="/contacto" class="header__nav-cta" @click="menuOpen = false">Contacto</router-link>
      </nav>

      <button class="header__hamburger" :class="{ 'is-open': menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const isScrolled = ref(false)
const menuOpen = ref(false)

function handleScroll() {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: $space-lg 0;
  transition: all $transition-base;
  background-color: transparent;

  &--scrolled {
    background-color: rgba(250, 248, 245, 0.95);
    backdrop-filter: blur(10px);
    padding: $space-md 0;
    box-shadow: $shadow-sm;
  }

  &__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  &__logo {
    display: flex;
    flex-direction: column;
    line-height: 1;

    &-text {
      font-family: $font-serif;
      font-size: $font-size-xl;
      font-weight: 500;
      color: $color-dark;
      letter-spacing: 0.05em;
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

  &__nav {
    display: flex;
    align-items: center;
    gap: $space-2xl;

    a {
      font-size: $font-size-xs;
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: $color-charcoal;
      position: relative;

      &::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0;
        height: 1px;
        background: $color-gold;
        transition: width $transition-base;
      }

      &:hover::after,
      &.router-link-exact-active::after {
        width: 100%;
      }

      &.router-link-exact-active {
        color: $color-gold;
      }
    }

    &-cta {
      padding: $space-sm $space-lg !important;
      border: 1px solid $color-dark !important;
      transition: all $transition-base;

      &:hover {
        background-color: $color-dark;
        color: $color-ivory !important;
      }

      &::after {
        display: none !important;
      }
    }

    @media (max-width: $breakpoint-lg) {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: $color-ivory;
      flex-direction: column;
      justify-content: center;
      gap: $space-2xl;
      opacity: 0;
      visibility: hidden;
      transition: all $transition-base;

      &.is-open {
        opacity: 1;
        visibility: visible;
      }

      a {
        font-size: $font-size-lg;
      }
    }
  }

  &__hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    width: 28px;
    z-index: 1001;
    padding: 4px 0;

    @media (max-width: $breakpoint-lg) {
      display: flex;
    }

    span {
      width: 100%;
      height: 1.5px;
      background: $color-dark;
      transition: all $transition-base;
    }

    &.is-open {
      span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
      span:nth-child(2) { opacity: 0; }
      span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }
    }
  }
}
</style>

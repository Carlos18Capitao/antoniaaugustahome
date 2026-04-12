<template>
  <div class="admin-layout">
    <aside class="admin-sidebar" :class="{ open: sidebarOpen }">
      <div class="admin-sidebar__brand">
        <router-link to="/admin">AA Home</router-link>
      </div>
      <nav class="admin-sidebar__nav">
        <router-link to="/admin" exact class="admin-nav-item" @click="closeSidebar">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
          Dashboard
        </router-link>
        <router-link to="/admin/produtos" class="admin-nav-item" @click="closeSidebar">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a4 4 0 00-8 0v2"/></svg>
          Produtos
        </router-link>
        <router-link to="/admin/categorias" class="admin-nav-item" @click="closeSidebar">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
          Categorias
        </router-link>
        <router-link to="/admin/projetos" class="admin-nav-item" @click="closeSidebar">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
          Projetos
        </router-link>
        <router-link to="/admin/leads" class="admin-nav-item" @click="closeSidebar">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          Leads
        </router-link>
      </nav>
      <div class="admin-sidebar__footer">
        <a href="/" target="_blank" class="admin-nav-item">Ver Site</a>
        <button class="admin-nav-item" @click="logout">Sair</button>
      </div>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <button class="admin-topbar__toggle" @click="sidebarOpen = !sidebarOpen">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="admin-topbar__user" v-if="user">
          {{ user.name }}
        </div>
      </header>
      <main class="admin-content">
        <router-view />
      </main>
    </div>

    <div v-if="sidebarOpen" class="admin-overlay" @click="closeSidebar"></div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const sidebarOpen = ref(false)

const user = computed(() => authStore.user)

function closeSidebar() { sidebarOpen.value = false }

async function logout() {
  await authStore.logout()
  router.push('/admin/login')
}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-layout {
  display: flex; min-height: 100vh; background: #f5f5f5;
}

.admin-sidebar {
  width: 250px; background: $color-dark; color: #fff; display: flex; flex-direction: column;
  position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; transition: transform .3s ease;

  @media (max-width: $breakpoint-lg) {
    transform: translateX(-100%);
    &.open { transform: translateX(0); }
  }

  &__brand {
    padding: $space-xl $space-lg; border-bottom: 1px solid rgba(255,255,255,.1);
    a { color: $color-gold; font-family: $font-serif; font-size: $font-size-xl; text-decoration: none; }
  }

  &__nav {
    flex: 1; padding: $space-lg 0; overflow-y: auto;
  }

  &__footer {
    padding: $space-lg 0; border-top: 1px solid rgba(255,255,255,.1);
    button { width: 100%; text-align: left; background: none; border: none; font-family: $font-sans; cursor: pointer; }
  }
}

.admin-nav-item {
  display: flex; align-items: center; gap: $space-md;
  padding: $space-md $space-xl; color: rgba(255,255,255,.6);
  font-size: $font-size-sm; text-decoration: none; transition: all $transition-fast;

  &:hover, &.router-link-active { color: #fff; background: rgba(255,255,255,.05); }
  &.router-link-active { border-right: 3px solid $color-gold; }
}

.admin-main {
  flex: 1; margin-left: 250px;
  @media (max-width: $breakpoint-lg) { margin-left: 0; }
}

.admin-topbar {
  height: 60px; background: #fff; border-bottom: 1px solid #eee;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 $space-xl;

  &__toggle {
    display: none; background: none; border: none; cursor: pointer; padding: $space-sm;
    @media (max-width: $breakpoint-lg) { display: block; }
  }

  &__user { font-size: $font-size-sm; color: $color-charcoal; }
}

.admin-content { max-width: 1200px; margin: 0 auto; padding: $space-2xl; }

.admin-overlay {
  display: none;
  @media (max-width: $breakpoint-lg) {
    display: block; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99;
  }
}
</style>

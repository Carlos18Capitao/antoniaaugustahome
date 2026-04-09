<template>
  <div id="app" :class="{ 'is-admin': isAdminRoute }">
    <AppHeader v-if="!isAdminRoute" />
    <main>
      <router-view v-slot="{ Component }">
        <transition name="page-fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>
    <AppFooter v-if="!isAdminRoute" />
    <WhatsAppButton v-if="!isAdminRoute" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import WhatsAppButton from '@/components/ui/WhatsAppButton.vue'

const route = useRoute()
const isAdminRoute = computed(() => route.path.startsWith('/admin'))
</script>

<template>
  <div class="dashboard">
    <h1 class="admin-page-title">Dashboard</h1>

    <!-- Stats -->
    <div class="stats-grid" v-if="stats">
      <div class="stat-card">
        <div class="stat-card__value">{{ stats.products?.total ?? 0 }}</div>
        <div class="stat-card__label">Produtos</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">{{ stats.projects?.total ?? 0 }}</div>
        <div class="stat-card__label">Projetos</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">{{ stats.leads?.new ?? 0 }}</div>
        <div class="stat-card__label">Novos Leads</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">{{ stats.views?.today ?? 0 }}</div>
        <div class="stat-card__label">Visitas Hoje</div>
      </div>
    </div>

    <div class="dashboard-grid">
      <!-- Recent Leads -->
      <div class="admin-card">
        <div class="admin-card__header">
          <h2>Leads Recentes</h2>
          <router-link to="/admin/leads" class="admin-card__link">Ver todos →</router-link>
        </div>
        <div class="admin-card__body">
          <table class="admin-table" v-if="recentLeads.length">
            <thead>
              <tr><th>Nome</th><th>Assunto</th><th>Data</th><th>Estado</th></tr>
            </thead>
            <tbody>
              <tr v-for="lead in recentLeads" :key="lead.id">
                <td>{{ lead.name }}</td>
                <td>{{ lead.subject }}</td>
                <td>{{ formatDate(lead.created_at) }}</td>
                <td><span class="badge" :class="`badge--${lead.status}`">{{ statusLabel(lead.status) }}</span></td>
              </tr>
            </tbody>
          </table>
          <p v-else class="admin-empty">Sem leads recentes.</p>
        </div>
      </div>

      <!-- Popular Products -->
      <div class="admin-card">
        <div class="admin-card__header">
          <h2>Produtos Populares</h2>
          <router-link to="/admin/produtos" class="admin-card__link">Ver todos →</router-link>
        </div>
        <div class="admin-card__body">
          <div v-if="popularProducts.length" class="popular-list">
            <div v-for="product in popularProducts" :key="product.id" class="popular-item">
              <span class="popular-item__name">{{ product.name }}</span>
              <span class="popular-item__views">{{ product.views_count }} visitas</span>
            </div>
          </div>
          <p v-else class="admin-empty">Sem dados de visualizações.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api'

const stats = ref(null)
const recentLeads = ref([])
const popularProducts = ref([])

const statusLabels = { new: 'Novo', contacted: 'Contactado', converted: 'Convertido', archived: 'Arquivado' }
function statusLabel(s) { return statusLabels[s] || s }
function formatDate(d) { return new Date(d).toLocaleDateString('pt-PT') }

onMounted(async () => {
  try {
    const { data } = await api.admin.dashboard()
    stats.value = data.metrics
    recentLeads.value = data.recent_leads || []
    popularProducts.value = data.popular_products || []
  } catch (e) {
    console.error('Dashboard error', e)
  }
})
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-title { font-size: $font-size-2xl; margin-bottom: $space-2xl; font-family: $font-sans; font-weight: 600; }

.stats-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-lg; margin-bottom: $space-2xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: repeat(2, 1fr); }
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.stat-card {
  background: #fff; padding: $space-xl; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06);
  &__value { font-size: $font-size-3xl; font-weight: 700; color: $color-dark; }
  &__label { font-size: $font-size-sm; color: $color-warm-gray; margin-top: $space-xs; }
}

.dashboard-grid {
  display: grid; grid-template-columns: 1.5fr 1fr; gap: $space-xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: 1fr; }
}

.admin-card {
  background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06);
  &__header {
    display: flex; justify-content: space-between; align-items: center;
    padding: $space-lg $space-xl; border-bottom: 1px solid #f0f0f0;
    h2 { font-size: $font-size-base; font-family: $font-sans; font-weight: 600; margin: 0; }
  }
  &__link { font-size: $font-size-sm; color: $color-gold; }
  &__body { padding: $space-lg $space-xl; }
}

.admin-table {
  width: 100%; border-collapse: collapse;
  th { text-align: left; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .05em; color: $color-warm-gray; padding: $space-sm 0; border-bottom: 1px solid #f0f0f0; }
  td { padding: $space-md 0; border-bottom: 1px solid #f8f8f8; font-size: $font-size-sm; }
}

.badge {
  display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
  &--new { background: #e8f4fd; color: #0277bd; }
  &--contacted { background: #fff3e0; color: #ef6c00; }
  &--converted { background: #e8f5e9; color: #2e7d32; }
  &--archived { background: #f5f5f5; color: #9e9e9e; }
}

.popular-list { display: flex; flex-direction: column; gap: $space-sm; }
.popular-item {
  display: flex; justify-content: space-between; align-items: center;
  padding: $space-sm 0; border-bottom: 1px solid #f8f8f8;
  &__name { font-size: $font-size-sm; }
  &__views { font-size: $font-size-xs; color: $color-warm-gray; }
}

.admin-empty { color: $color-warm-gray; font-size: $font-size-sm; text-align: center; padding: $space-xl 0; }
</style>

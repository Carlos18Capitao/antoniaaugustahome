<template>
  <div class="admin-leads">
    <div class="admin-page-header">
      <h1 class="admin-page-title">Leads</h1>
      <div class="admin-page-header__actions">
        <select v-model="statusFilter" class="admin-select">
          <option value="">Todos os estados</option>
          <option value="new">Novo</option>
          <option value="contacted">Contactado</option>
          <option value="converted">Convertido</option>
          <option value="archived">Arquivado</option>
        </select>
      </div>
    </div>

    <div class="admin-card">
      <table class="admin-table" v-if="leads.length">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Assunto</th>
            <th>Data</th>
            <th>Estado</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="lead in leads" :key="lead.id" :class="{ 'lead-new': lead.status === 'new' }">
            <td><strong>{{ lead.name }}</strong></td>
            <td>{{ lead.email }}</td>
            <td>{{ lead.subject || '—' }}</td>
            <td>{{ formatDate(lead.created_at) }}</td>
            <td>
              <select :value="lead.status" @change="updateStatus(lead.id, $event.target.value)" class="status-select" :class="`status-select--${lead.status}`">
                <option value="new">Novo</option>
                <option value="contacted">Contactado</option>
                <option value="converted">Convertido</option>
                <option value="archived">Arquivado</option>
              </select>
            </td>
            <td>
              <button class="action-btn" @click="viewLead(lead)">Ver</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else class="admin-empty">Nenhum lead encontrado.</p>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination" v-if="lastPage > 1">
      <button :disabled="page <= 1" @click="page--" class="btn btn--outline btn--sm">← Anterior</button>
      <span class="admin-pagination__info">{{ page }} / {{ lastPage }}</span>
      <button :disabled="page >= lastPage" @click="page++" class="btn btn--outline btn--sm">Seguinte →</button>
    </div>

    <!-- Detail Modal -->
    <Teleport to="body">
      <div v-if="selectedLead" class="modal-overlay" @click.self="selectedLead = null">
        <div class="modal">
          <div class="modal__header">
            <h2>Lead de {{ selectedLead.name }}</h2>
            <button @click="selectedLead = null" class="modal__close">&times;</button>
          </div>
          <div class="modal__body">
            <div class="lead-detail">
              <div class="lead-detail__row">
                <span class="lead-detail__label">Nome</span>
                <span>{{ selectedLead.name }}</span>
              </div>
              <div class="lead-detail__row">
                <span class="lead-detail__label">Email</span>
                <a :href="`mailto:${selectedLead.email}`">{{ selectedLead.email }}</a>
              </div>
              <div class="lead-detail__row" v-if="selectedLead.phone">
                <span class="lead-detail__label">Telefone</span>
                <a :href="`tel:${selectedLead.phone}`">{{ selectedLead.phone }}</a>
              </div>
              <div class="lead-detail__row" v-if="selectedLead.subject">
                <span class="lead-detail__label">Assunto</span>
                <span>{{ selectedLead.subject }}</span>
              </div>
              <div class="lead-detail__row" v-if="selectedLead.source">
                <span class="lead-detail__label">Origem</span>
                <span>{{ selectedLead.source }}</span>
              </div>
              <div class="lead-detail__row">
                <span class="lead-detail__label">Data</span>
                <span>{{ formatDate(selectedLead.created_at) }}</span>
              </div>
              <div class="lead-detail__message" v-if="selectedLead.message">
                <span class="lead-detail__label">Mensagem</span>
                <p>{{ selectedLead.message }}</p>
              </div>
              <div class="lead-detail__notes" v-if="selectedLead.notes">
                <span class="lead-detail__label">Notas</span>
                <p>{{ selectedLead.notes }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import api from '@/api'

const leads = ref([])
const statusFilter = ref('')
const page = ref(1)
const lastPage = ref(1)
const selectedLead = ref(null)

function formatDate(d) { return new Date(d).toLocaleDateString('pt-PT', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }

async function fetchLeads() {
  try {
    const params = { page: page.value }
    if (statusFilter.value) params.status = statusFilter.value
    const { data } = await api.admin.leads.list(params)
    leads.value = data.data
    lastPage.value = data.meta?.last_page || 1
  } catch (e) { console.error(e) }
}

async function updateStatus(id, status) {
  try {
    await api.admin.leads.updateStatus(id, status)
    fetchLeads()
  } catch (e) { console.error(e) }
}

function viewLead(lead) { selectedLead.value = lead }

watch(statusFilter, () => { page.value = 1; fetchLeads() })
watch(page, fetchLeads)
onMounted(fetchLeads)
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: $space-xl; flex-wrap: wrap; gap: $space-md; }
.admin-page-title { font-size: $font-size-2xl; font-family: $font-sans; font-weight: 600; margin: 0; }

.admin-select {
  padding: $space-sm $space-lg; border: 1px solid #ddd; font-size: $font-size-sm; background: #fff;
  &:focus { outline: none; border-color: $color-gold; }
}

.admin-card { background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); overflow-x: auto; }
.admin-table {
  width: 100%; border-collapse: collapse;
  th { text-align: left; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .05em; color: $color-warm-gray; padding: $space-md $space-lg; border-bottom: 1px solid #f0f0f0; }
  td { padding: $space-md $space-lg; border-bottom: 1px solid #f8f8f8; font-size: $font-size-sm; vertical-align: middle; }
}

.lead-new td { background: rgba(2, 119, 189, .03); }

.status-select {
  padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 500; border: none; cursor: pointer; appearance: auto;
  &--new { background: #e8f4fd; color: #0277bd; }
  &--contacted { background: #fff3e0; color: #ef6c00; }
  &--converted { background: #e8f5e9; color: #2e7d32; }
  &--archived { background: #f5f5f5; color: #9e9e9e; }
}

.action-btn {
  font-size: $font-size-xs; color: $color-gold; background: none; border: none; cursor: pointer;
  text-decoration: underline; text-underline-offset: 3px;
}

.admin-pagination {
  display: flex; align-items: center; justify-content: center; gap: $space-lg; margin-top: $space-xl;
  &__info { font-size: $font-size-sm; color: $color-warm-gray; }
}

.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center; z-index: 1000; }
.modal {
  background: #fff; width: 100%; max-width: 600px; border-radius: 4px; box-shadow: 0 12px 48px rgba(0,0,0,.15); max-height: 90vh; overflow-y: auto;
  &__header { display: flex; justify-content: space-between; align-items: center; padding: $space-lg $space-xl; border-bottom: 1px solid #f0f0f0;
    h2 { font-size: $font-size-base; font-family: $font-sans; font-weight: 600; margin: 0; }
  }
  &__close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: $color-warm-gray; }
  &__body { padding: $space-xl; }
}

.lead-detail {
  &__row { display: flex; gap: $space-lg; padding: $space-sm 0; border-bottom: 1px solid #f8f8f8;
    a { color: $color-gold; }
  }
  &__label { font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .08em; color: $color-warm-gray; width: 100px; flex-shrink: 0; padding-top: 2px; }
  &__message, &__notes { margin-top: $space-lg;
    p { background: #f9f9f9; padding: $space-lg; margin-top: $space-sm; line-height: 1.8; white-space: pre-wrap; }
  }
}

.admin-empty { text-align: center; padding: $space-2xl; color: $color-warm-gray; font-size: $font-size-sm; }
</style>

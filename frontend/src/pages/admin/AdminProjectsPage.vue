<template>
  <div class="admin-projects">
    <div class="admin-page-header">
      <h1 class="admin-page-title">Projetos</h1>
      <router-link to="/admin/projetos/novo" class="btn btn--primary btn--sm">+ Novo Projeto</router-link>
    </div>

    <div class="admin-card">
      <table class="admin-table" v-if="projects.length">
        <thead>
          <tr>
            <th>Projeto</th>
            <th>Localização</th>
            <th>Estado</th>
            <th>Destaque</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in projects" :key="project.id">
            <td>{{ project.title }}</td>
            <td>{{ project.location || '—' }}</td>
            <td>
              <span class="badge" :class="project.is_active ? 'badge--active' : 'badge--inactive'">
                {{ project.is_active ? 'Ativo' : 'Inativo' }}
              </span>
            </td>
            <td>{{ project.is_featured ? '★' : '—' }}</td>
            <td>
              <div class="action-btns">
                <router-link :to="`/admin/projetos/${project.id}/editar`" class="action-btn">Editar</router-link>
                <button class="action-btn action-btn--danger" @click="handleDelete(project)">Eliminar</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else class="admin-empty">Nenhum projeto encontrado.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api'

const projects = ref([])

async function fetchProjects() {
  try {
    const { data } = await api.admin.projects.list()
    projects.value = data.data || data
  } catch (e) { console.error(e) }
}

async function handleDelete(project) {
  if (!confirm(`Eliminar "${project.title}"?`)) return
  try {
    await api.admin.projects.delete(project.id)
    fetchProjects()
  } catch (e) { console.error(e) }
}

onMounted(fetchProjects)
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: $space-xl; }
.admin-page-title { font-size: $font-size-2xl; font-family: $font-sans; font-weight: 600; margin: 0; }

.admin-card { background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); overflow-x: auto; }
.admin-table {
  width: 100%; border-collapse: collapse;
  th { text-align: left; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .05em; color: $color-warm-gray; padding: $space-md $space-lg; border-bottom: 1px solid #f0f0f0; }
  td { padding: $space-md $space-lg; border-bottom: 1px solid #f8f8f8; font-size: $font-size-sm; vertical-align: middle; }
}

.badge {
  display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
  &--active { background: #e8f5e9; color: #2e7d32; }
  &--inactive { background: #f5f5f5; color: #9e9e9e; }
}

.action-btns { display: flex; gap: $space-sm; }
.action-btn {
  font-size: $font-size-xs; color: $color-gold; background: none; border: none; cursor: pointer;
  text-decoration: underline; text-underline-offset: 3px;
  &--danger { color: $color-error; }
}

.admin-empty { text-align: center; padding: $space-2xl; color: $color-warm-gray; font-size: $font-size-sm; }
</style>

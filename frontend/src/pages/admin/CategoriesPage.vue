<template>
  <div class="admin-categories">
    <div class="admin-page-header">
      <h1 class="admin-page-title">Categorias</h1>
      <button class="btn btn--primary btn--sm" @click="openModal()">+ Nova Categoria</button>
    </div>

    <div class="admin-card">
      <table class="admin-table" v-if="categories.length">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Produtos</th>
            <th>Ordem</th>
            <th>Estado</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cat in categories" :key="cat.id">
            <td>{{ cat.name }}</td>
            <td>{{ cat.products_count ?? 0 }}</td>
            <td>{{ cat.sort_order }}</td>
            <td>
              <span class="badge" :class="cat.is_active ? 'badge--active' : 'badge--inactive'">
                {{ cat.is_active ? 'Ativa' : 'Inativa' }}
              </span>
            </td>
            <td>
              <div class="action-btns">
                <button class="action-btn" @click="openModal(cat)">Editar</button>
                <button class="action-btn action-btn--danger" @click="deleteCategory(cat)">Eliminar</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else class="admin-empty">Nenhuma categoria encontrada.</p>
    </div>

    <!-- Modal -->
    <Teleport to="body">
      <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
        <div class="modal">
          <div class="modal__header">
            <h2>{{ editing ? 'Editar Categoria' : 'Nova Categoria' }}</h2>
            <button @click="showModal = false" class="modal__close">&times;</button>
          </div>
          <form @submit.prevent="submitCategory">
            <div class="modal__body">
              <div class="form-group">
                <label>Nome *</label>
                <input v-model="form.name" type="text" required placeholder="Nome da categoria" />
                <span class="form-error" v-if="formErrors.name">{{ formErrors.name[0] }}</span>
              </div>
              <div class="form-group">
                <label>Descrição</label>
                <textarea v-model="form.description" rows="3" placeholder="Descrição opcional"></textarea>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>Ordem</label>
                  <input v-model.number="form.sort_order" type="number" min="0" />
                </div>
                <div class="form-check" style="padding-top: 1.5rem;">
                  <label><input type="checkbox" v-model="form.is_active" /> Ativa</label>
                </div>
              </div>
            </div>
            <div class="modal__footer">
              <button type="button" class="btn btn--outline btn--sm" @click="showModal = false">Cancelar</button>
              <button type="submit" class="btn btn--primary btn--sm" :disabled="submitting">
                {{ submitting ? 'A guardar...' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import api from '@/api'

const categories = ref([])
const showModal = ref(false)
const editing = ref(null)
const submitting = ref(false)
const formErrors = ref({})

const form = reactive({ name: '', description: '', sort_order: 0, is_active: true })

async function fetchCategories() {
  try {
    const { data } = await api.admin.categories.list()
    categories.value = data.data || data
  } catch (e) { console.error(e) }
}

function openModal(cat = null) {
  editing.value = cat
  formErrors.value = {}
  if (cat) {
    Object.assign(form, { name: cat.name, description: cat.description || '', sort_order: cat.sort_order, is_active: cat.is_active })
  } else {
    Object.assign(form, { name: '', description: '', sort_order: 0, is_active: true })
  }
  showModal.value = true
}

async function submitCategory() {
  submitting.value = true; formErrors.value = {}
  try {
    if (editing.value) {
      await api.admin.categories.update(editing.value.id, form)
    } else {
      await api.admin.categories.create(form)
    }
    showModal.value = false
    fetchCategories()
  } catch (e) {
    if (e.response?.status === 422) formErrors.value = e.response.data.errors || {}
  } finally {
    submitting.value = false
  }
}

async function deleteCategory(cat) {
  if (!confirm(`Eliminar "${cat.name}"? Os produtos associados ficarão sem categoria.`)) return
  try {
    await api.admin.categories.delete(cat.id)
    fetchCategories()
  } catch (e) { console.error(e) }
}

onMounted(fetchCategories)
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: $space-xl; }
.admin-page-title { font-size: $font-size-2xl; font-family: $font-sans; font-weight: 600; margin: 0; }

.admin-card { background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); overflow-x: auto; }
.admin-table {
  width: 100%; border-collapse: collapse;
  th { text-align: left; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .05em; color: $color-warm-gray; padding: $space-md $space-lg; border-bottom: 1px solid #f0f0f0; }
  td { padding: $space-md $space-lg; border-bottom: 1px solid #f8f8f8; font-size: $font-size-sm; }
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

.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center; z-index: 1000; }
.modal {
  background: #fff; width: 100%; max-width: 500px; border-radius: 4px; box-shadow: 0 12px 48px rgba(0,0,0,.15);
  &__header { display: flex; justify-content: space-between; align-items: center; padding: $space-lg $space-xl; border-bottom: 1px solid #f0f0f0;
    h2 { font-size: $font-size-base; font-family: $font-sans; font-weight: 600; margin: 0; }
  }
  &__close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: $color-warm-gray; }
  &__body { padding: $space-xl; }
  &__footer { display: flex; justify-content: flex-end; gap: $space-md; padding: $space-lg $space-xl; border-top: 1px solid #f0f0f0; }
}

.form-group {
  margin-bottom: $space-lg;
  label { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .08em; margin-bottom: $space-sm; color: $color-charcoal; font-weight: 500; }
  input, textarea { width: 100%; padding: $space-sm $space-md; border: 1px solid #ddd; font-size: $font-size-sm; &:focus { outline: none; border-color: $color-gold; } }
  textarea { resize: vertical; }
}
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: $space-lg; }
.form-check label { display: flex; align-items: center; gap: $space-sm; font-size: $font-size-sm; cursor: pointer;
  input { width: auto; }
}
.form-error { display: block; color: $color-error; font-size: $font-size-xs; margin-top: $space-xs; }
.admin-empty { text-align: center; padding: $space-2xl; color: $color-warm-gray; font-size: $font-size-sm; }
</style>

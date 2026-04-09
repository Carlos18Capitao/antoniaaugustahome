<template>
  <div class="product-form-page">
    <div class="admin-page-header">
      <h1 class="admin-page-title">{{ isEditing ? 'Editar Produto' : 'Novo Produto' }}</h1>
      <router-link to="/admin/produtos" class="btn btn--outline btn--sm">← Voltar</router-link>
    </div>

    <form @submit.prevent="submitForm">
      <div class="form-grid">
        <!-- Main Content -->
        <div class="form-main">
          <div class="admin-card">
            <div class="admin-card__body">
              <div class="form-group">
                <label>Nome do Produto *</label>
                <input v-model="form.name" type="text" required placeholder="Nome do produto" />
                <span class="form-error" v-if="errors.name">{{ errors.name[0] }}</span>
              </div>

              <div class="form-group">
                <label>Descrição Curta</label>
                <textarea v-model="form.short_description" rows="2" placeholder="Breve descrição para listagens"></textarea>
              </div>

              <div class="form-group">
                <label>Descrição Completa</label>
                <textarea v-model="form.description" rows="8" placeholder="Descrição detalhada do produto"></textarea>
                <span class="form-error" v-if="errors.description">{{ errors.description[0] }}</span>
              </div>
            </div>
          </div>

          <!-- Details -->
          <div class="admin-card">
            <div class="admin-card__header"><h2>Detalhes</h2></div>
            <div class="admin-card__body">
              <div class="form-row">
                <div class="form-group">
                  <label>Dimensões</label>
                  <input v-model="form.dimensions" type="text" placeholder="Ex: 180x90x75 cm" />
                </div>
                <div class="form-group">
                  <label>Materiais</label>
                  <input v-model="form.materials" type="text" placeholder="Ex: Madeira maciça, veludo" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>Cores</label>
                  <input v-model="form.colors" type="text" placeholder="Ex: Natural, Nogueira" />
                </div>
                <div class="form-group">
                  <label>Preço (€)</label>
                  <input v-model="form.price" type="number" step="0.01" min="0" placeholder="0.00" />
                </div>
              </div>
            </div>
          </div>

          <!-- Images -->
          <div class="admin-card" v-if="isEditing">
            <div class="admin-card__header"><h2>Imagens</h2></div>
            <div class="admin-card__body">
              <div class="images-grid" v-if="images.length">
                <div v-for="img in images" :key="img.id" class="image-item">
                  <img :src="img.thumbnail_url || img.url" :alt="img.alt_text" />
                  <div class="image-item__actions">
                    <button type="button" @click="deleteImage(img.id)" class="image-item__delete">&times;</button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Adicionar Imagem</label>
                <input type="file" accept="image/*" @change="uploadImage" :disabled="uploading" />
                <span v-if="uploading" class="form-hint">A carregar...</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="form-sidebar">
          <div class="admin-card">
            <div class="admin-card__header"><h2>Publicação</h2></div>
            <div class="admin-card__body">
              <div class="form-group">
                <label>Categoria *</label>
                <select v-model="form.category_id" required>
                  <option value="">Selecionar</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
                <span class="form-error" v-if="errors.category_id">{{ errors.category_id[0] }}</span>
              </div>

              <div class="form-check">
                <label><input type="checkbox" v-model="form.is_active" /> Ativo</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" v-model="form.is_featured" /> Destaque</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" v-model="form.is_available" /> Disponível</label>
              </div>

              <button type="submit" class="btn btn--primary btn--full" :disabled="submitting" style="margin-top: 1rem;">
                {{ submitting ? 'A guardar...' : 'Guardar Produto' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/api'

const route = useRoute()
const router = useRouter()

const isEditing = computed(() => !!route.params.id)
const categories = ref([])
const images = ref([])
const errors = ref({})
const submitting = ref(false)
const uploading = ref(false)

const form = reactive({
  name: '', description: '', short_description: '',
  price: null, category_id: '',
  dimensions: '', materials: '', colors: '',
  is_active: true, is_featured: false, is_available: true,
})

async function loadProduct() {
  if (!isEditing.value) return
  try {
    const { data } = await api.admin.products.get(route.params.id)
    const p = data.data || data
    Object.assign(form, {
      name: p.name, description: p.description || '', short_description: p.short_description || '',
      price: p.price, category_id: p.category_id,
      dimensions: p.dimensions || '', materials: p.materials || '', colors: p.colors || '',
      is_active: p.is_active, is_featured: p.is_featured, is_available: p.is_available,
    })
    images.value = p.images || []
  } catch (e) { console.error(e) }
}

async function loadCategories() {
  try {
    const { data } = await api.admin.categories.list()
    categories.value = data.data || data
  } catch (e) { console.error(e) }
}

async function submitForm() {
  submitting.value = true; errors.value = {}
  try {
    if (isEditing.value) {
      await api.admin.products.update(route.params.id, form)
    } else {
      await api.admin.products.create(form)
    }
    router.push('/admin/produtos')
  } catch (e) {
    if (e.response?.status === 422) errors.value = e.response.data.errors || {}
  } finally {
    submitting.value = false
  }
}

async function uploadImage(e) {
  const file = e.target.files?.[0]
  if (!file) return
  uploading.value = true
  try {
    const fd = new FormData()
    fd.append('image', file)
    await api.admin.products.uploadImage(route.params.id, fd)
    await loadProduct()
  } catch (er) { console.error(er) }
  finally { uploading.value = false; e.target.value = '' }
}

async function deleteImage(imageId) {
  if (!confirm('Eliminar esta imagem?')) return
  try {
    await api.admin.products.deleteImage(route.params.id, imageId)
    images.value = images.value.filter(i => i.id !== imageId)
  } catch (e) { console.error(e) }
}

onMounted(() => { loadCategories(); loadProduct() })
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.admin-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: $space-xl; }
.admin-page-title { font-size: $font-size-2xl; font-family: $font-sans; font-weight: 600; margin: 0; }

.form-grid {
  display: grid; grid-template-columns: 1fr 300px; gap: $space-xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: 1fr; }
}

.admin-card {
  background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); margin-bottom: $space-xl;
  &__header {
    padding: $space-lg $space-xl; border-bottom: 1px solid #f0f0f0;
    h2 { font-size: $font-size-sm; font-family: $font-sans; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: .05em; }
  }
  &__body { padding: $space-xl; }
}

.form-group {
  margin-bottom: $space-lg;
  label { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .08em; margin-bottom: $space-sm; color: $color-charcoal; font-weight: 500; }
  input, select, textarea {
    width: 100%; padding: $space-sm $space-md; border: 1px solid #ddd; font-size: $font-size-sm; color: $color-dark; background: #fff;
    &:focus { outline: none; border-color: $color-gold; }
  }
  textarea { resize: vertical; }
}

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: $space-lg;
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.form-check {
  margin-bottom: $space-sm;
  label { display: flex; align-items: center; gap: $space-sm; font-size: $font-size-sm; cursor: pointer; }
  input[type="checkbox"] { width: auto; }
}

.form-error { display: block; color: $color-error; font-size: $font-size-xs; margin-top: $space-xs; }
.form-hint { display: block; color: $color-warm-gray; font-size: $font-size-xs; margin-top: $space-xs; }

.images-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-md; margin-bottom: $space-lg;
  @media (max-width: $breakpoint-sm) { grid-template-columns: repeat(2, 1fr); }
}

.image-item {
  position: relative; aspect-ratio: 1; overflow: hidden; background: $color-beige;
  img { width: 100%; height: 100%; object-fit: cover; }
  &__actions { position: absolute; top: 4px; right: 4px; }
  &__delete { width: 24px; height: 24px; background: rgba(0,0,0,.6); color: #fff; border: none; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; }
}
</style>

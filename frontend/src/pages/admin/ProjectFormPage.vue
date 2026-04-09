<template>
  <div class="project-form-page">
    <div class="admin-page-header">
      <h1 class="admin-page-title">{{ isEditing ? 'Editar Projeto' : 'Novo Projeto' }}</h1>
      <router-link to="/admin/projetos" class="btn btn--outline btn--sm">← Voltar</router-link>
    </div>

    <form @submit.prevent="submitForm">
      <div class="form-grid">
        <div class="form-main">
          <div class="admin-card">
            <div class="admin-card__body">
              <div class="form-group">
                <label>Título do Projeto *</label>
                <input v-model="form.title" type="text" required placeholder="Título do projeto" />
                <span class="form-error" v-if="errors.title">{{ errors.title[0] }}</span>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>Localização</label>
                  <input v-model="form.location" type="text" placeholder="Ex: Luanda, Angola" />
                </div>
                <div class="form-group">
                  <label>Cliente</label>
                  <input v-model="form.client_name" type="text" placeholder="Nome do cliente" />
                </div>
              </div>
              <div class="form-group">
                <label>Descrição</label>
                <textarea v-model="form.description" rows="8" placeholder="Descrição do projeto"></textarea>
              </div>
              <div class="form-group">
                <label>Data de Conclusão</label>
                <input v-model="form.completed_at" type="date" />
              </div>
            </div>
          </div>

          <!-- Images -->
          <div class="admin-card" v-if="isEditing">
            <div class="admin-card__header"><h2>Galeria</h2></div>
            <div class="admin-card__body">
              <div class="images-grid" v-if="images.length">
                <div v-for="img in images" :key="img.id" class="image-item">
                  <img :src="img.thumbnail_url || img.url" :alt="img.alt_text" />
                  <button type="button" @click="deleteImage(img.id)" class="image-item__delete">&times;</button>
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

        <div class="form-sidebar">
          <div class="admin-card">
            <div class="admin-card__header"><h2>Publicação</h2></div>
            <div class="admin-card__body">
              <div class="form-check">
                <label><input type="checkbox" v-model="form.is_active" /> Ativo</label>
              </div>
              <div class="form-check">
                <label><input type="checkbox" v-model="form.is_featured" /> Destaque</label>
              </div>
              <div class="form-group" style="margin-top: 1rem;">
                <label>Imagem de Capa</label>
                <input type="file" accept="image/*" @change="uploadCover" :disabled="uploadingCover" />
                <span v-if="uploadingCover" class="form-hint">A carregar...</span>
              </div>
              <div v-if="form.cover_image" class="cover-preview">
                <img :src="form.cover_image" alt="Capa" />
              </div>
              <button type="submit" class="btn btn--primary btn--full" :disabled="submitting" style="margin-top: 1rem;">
                {{ submitting ? 'A guardar...' : 'Guardar Projeto' }}
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

const images = ref([])
const errors = ref({})
const submitting = ref(false)
const uploading = ref(false)
const uploadingCover = ref(false)

const form = reactive({
  title: '', description: '', location: '', client_name: '',
  cover_image: '', is_active: true, is_featured: false, completed_at: '',
})

async function loadProject() {
  if (!isEditing.value) return
  try {
    const { data } = await api.admin.projects.get(route.params.id)
    const p = data.data || data
    Object.assign(form, {
      title: p.title, description: p.description || '', location: p.location || '',
      client_name: p.client_name || '', cover_image: p.cover_image || '',
      is_active: p.is_active, is_featured: p.is_featured, completed_at: p.completed_at || '',
    })
    images.value = p.images || []
  } catch (e) { console.error(e) }
}

async function submitForm() {
  submitting.value = true; errors.value = {}
  try {
    if (isEditing.value) {
      await api.admin.projects.update(route.params.id, form)
    } else {
      await api.admin.projects.create(form)
    }
    router.push('/admin/projetos')
  } catch (e) {
    if (e.response?.status === 422) errors.value = e.response.data.errors || {}
  } finally { submitting.value = false }
}

async function uploadImage(e) {
  const file = e.target.files?.[0]
  if (!file) return
  uploading.value = true
  try {
    const fd = new FormData(); fd.append('image', file)
    await api.admin.projects.uploadImage(route.params.id, fd)
    await loadProject()
  } catch (er) { console.error(er) }
  finally { uploading.value = false; e.target.value = '' }
}

async function uploadCover(e) {
  const file = e.target.files?.[0]
  if (!file) return
  uploadingCover.value = true
  try {
    const fd = new FormData(); fd.append('cover_image', file)
    await api.admin.projects.update(route.params.id, fd)
    await loadProject()
  } catch (er) { console.error(er) }
  finally { uploadingCover.value = false; e.target.value = '' }
}

async function deleteImage(imageId) {
  if (!confirm('Eliminar esta imagem?')) return
  try {
    await api.admin.projects.deleteImage(route.params.id, imageId)
    images.value = images.value.filter(i => i.id !== imageId)
  } catch (e) { console.error(e) }
}

onMounted(loadProject)
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
  &__header { padding: $space-lg $space-xl; border-bottom: 1px solid #f0f0f0;
    h2 { font-size: $font-size-sm; font-family: $font-sans; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: .05em; }
  }
  &__body { padding: $space-xl; }
}

.form-group {
  margin-bottom: $space-lg;
  label { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: .08em; margin-bottom: $space-sm; color: $color-charcoal; font-weight: 500; }
  input, textarea { width: 100%; padding: $space-sm $space-md; border: 1px solid #ddd; font-size: $font-size-sm; &:focus { outline: none; border-color: $color-gold; } }
  textarea { resize: vertical; }
}

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: $space-lg;
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.form-check {
  margin-bottom: $space-sm;
  label { display: flex; align-items: center; gap: $space-sm; font-size: $font-size-sm; cursor: pointer; }
  input { width: auto; }
}

.form-error { display: block; color: $color-error; font-size: $font-size-xs; margin-top: $space-xs; }
.form-hint { display: block; color: $color-warm-gray; font-size: $font-size-xs; margin-top: $space-xs; }

.images-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-md; margin-bottom: $space-lg; }
.image-item {
  position: relative; aspect-ratio: 1; overflow: hidden; background: $color-beige;
  img { width: 100%; height: 100%; object-fit: cover; }
  &__delete { position: absolute; top: 4px; right: 4px; width: 24px; height: 24px; background: rgba(0,0,0,.6); color: #fff; border: none; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; }
}

.cover-preview {
  margin-top: $space-md; aspect-ratio: 16/9; overflow: hidden; background: $color-beige;
  img { width: 100%; height: 100%; object-fit: cover; }
}
</style>

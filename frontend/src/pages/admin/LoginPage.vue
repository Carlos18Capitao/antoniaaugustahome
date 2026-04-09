<template>
  <div class="login-page">
    <div class="login-card">
      <div class="login-card__brand">
        <h1>AA Home</h1>
        <p>Painel de Administração</p>
      </div>

      <div v-if="error" class="login-error">{{ error }}</div>

      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" v-model="form.email" type="email" required placeholder="admin@antonioaugustahome.pt" autocomplete="username" />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" v-model="form.password" type="password" required placeholder="••••••••" autocomplete="current-password" />
        </div>
        <button type="submit" class="btn btn--primary btn--full" :disabled="loading">
          {{ loading ? 'A entrar...' : 'Entrar' }}
        </button>
      </form>

      <div class="login-card__footer">
        <router-link to="/">← Voltar ao site</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({ email: '', password: '' })
const loading = ref(false)
const error = ref('')

async function handleLogin() {
  loading.value = true
  error.value = ''

  try {
    await authStore.login(form)
    router.push('/admin')
  } catch (e) {
    error.value = e.response?.data?.message || 'Credenciais inválidas.'
  } finally {
    loading.value = false
  }
}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.login-page {
  min-height: 100vh; display: flex; align-items: center; justify-content: center;
  background: $color-cream;
}

.login-card {
  width: 100%; max-width: 400px; background: #fff; padding: $space-3xl;
  box-shadow: 0 4px 24px rgba(0,0,0,.06);

  &__brand {
    text-align: center; margin-bottom: $space-2xl;
    h1 { font-family: $font-serif; font-size: $font-size-3xl; color: $color-dark; margin: 0; }
    p { color: $color-warm-gray; font-size: $font-size-sm; margin-top: $space-xs; }
  }

  .form-group {
    margin-bottom: $space-lg;
    label { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: $space-sm; color: $color-charcoal; }
    input {
      width: 100%; padding: $space-md $space-lg; border: 1px solid $color-beige;
      font-size: $font-size-base; color: $color-dark; background: #fff;
      &:focus { outline: none; border-color: $color-gold; }
    }
  }

  .btn--full { width: 100%; margin-top: $space-md; }

  &__footer { text-align: center; margin-top: $space-2xl;
    a { font-size: $font-size-sm; color: $color-warm-gray; &:hover { color: $color-dark; } }
  }
}

.login-error {
  background: rgba(200,50,50,.08); border: 1px solid rgba(200,50,50,.2);
  color: $color-error; padding: $space-md $space-lg; margin-bottom: $space-lg;
  font-size: $font-size-sm; text-align: center;
}
</style>

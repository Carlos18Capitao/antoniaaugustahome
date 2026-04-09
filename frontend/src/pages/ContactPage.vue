<template>
  <div class="contact-page">
    <!-- Hero -->
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Fale Connosco</span>
        <h1 class="page-hero__title">Contacto</h1>
        <div class="divider divider--center"></div>
        <p class="page-hero__text">Estamos disponíveis para o ajudar a criar o espaço dos seus sonhos.</p>
      </div>
    </section>

    <!-- Contact Content -->
    <section class="section">
      <div class="container">
        <div class="contact-grid">
          <!-- Form -->
          <div class="contact-form">
            <h2 class="contact-form__title">Envie-nos uma Mensagem</h2>

            <div v-if="success" class="alert alert--success">
              Mensagem enviada com sucesso! Entraremos em contacto brevemente.
            </div>

            <form @submit.prevent="submitForm" v-if="!success">
              <div class="form-row">
                <div class="form-group">
                  <label for="name">Nome Completo *</label>
                  <input id="name" v-model="form.name" type="text" required placeholder="O seu nome" />
                  <span class="form-error" v-if="errors.name">{{ errors.name[0] }}</span>
                </div>
              </div>

              <div class="form-row form-row--half">
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input id="email" v-model="form.email" type="email" required placeholder="email@exemplo.com" />
                  <span class="form-error" v-if="errors.email">{{ errors.email[0] }}</span>
                </div>
                <div class="form-group">
                  <label for="phone">Telefone</label>
                  <input id="phone" v-model="form.phone" type="tel" placeholder="+351 XXX XXX XXX" />
                  <span class="form-error" v-if="errors.phone">{{ errors.phone[0] }}</span>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="subject">Assunto *</label>
                  <select id="subject" v-model="form.subject" required>
                    <option value="">Selecione um assunto</option>
                    <option value="Informação sobre produto">Informação sobre produto</option>
                    <option value="Pedido de orçamento">Pedido de orçamento</option>
                    <option value="Consulta de decoração">Consulta de decoração</option>
                    <option value="Visita ao showroom">Visita ao showroom</option>
                    <option value="Outro">Outro</option>
                  </select>
                  <span class="form-error" v-if="errors.subject">{{ errors.subject[0] }}</span>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="message">Mensagem *</label>
                  <textarea id="message" v-model="form.message" rows="6" required placeholder="Conte-nos mais sobre o que procura..."></textarea>
                  <span class="form-error" v-if="errors.message">{{ errors.message[0] }}</span>
                </div>
              </div>

              <button type="submit" class="btn btn--primary btn--lg" :disabled="submitting">
                {{ submitting ? 'A enviar...' : 'Enviar Mensagem' }}
              </button>
            </form>
          </div>

          <!-- Info Sidebar -->
          <div class="contact-info">
            <div class="contact-info__card">
              <h3>Showroom</h3>
              <div class="contact-info__item">
                <strong>Morada</strong>
                <p>Rua Example, 123<br>1000-001 Lisboa, Portugal</p>
              </div>
              <div class="contact-info__item">
                <strong>Telefone</strong>
                <p>+351 XXX XXX XXX</p>
              </div>
              <div class="contact-info__item">
                <strong>Email</strong>
                <p>info@antonioaugustahome.pt</p>
              </div>
              <div class="contact-info__item">
                <strong>Horário</strong>
                <p>Segunda a Sexta: 10h — 19h<br>Sábado: 10h — 14h<br>Domingo: Encerrado</p>
              </div>
            </div>

            <div class="contact-info__social">
              <h4>Siga-nos</h4>
              <div class="contact-info__links">
                <a href="#" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="#" target="_blank" rel="noopener noreferrer">Pinterest</a>
                <a href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import api from '@/api'

const form = reactive({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
  source: 'website',
})

const errors = ref({})
const submitting = ref(false)
const success = ref(false)

async function submitForm() {
  submitting.value = true
  errors.value = {}

  try {
    await api.contact.send(form)
    success.value = true
  } catch (e) {
    if (e.response?.status === 422) {
      errors.value = e.response.data.errors || {}
    }
  } finally {
    submitting.value = false
  }
}
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-4xl;
  background: $color-cream; text-align: center;

  &__subtitle { font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.3em; color: $color-gold; display: block; margin-bottom: $space-md; }
  &__title { font-size: $font-size-5xl; margin-bottom: 0; }
  &__text { max-width: 500px; margin: $space-xl auto 0; color: $color-warm-gray; line-height: 1.8; }
}

.contact-grid {
  display: grid; grid-template-columns: 1.5fr 1fr; gap: $space-4xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: 1fr; }
}

.contact-form {
  &__title { font-size: $font-size-2xl; margin-bottom: $space-2xl; }

  .form-row {
    margin-bottom: $space-lg;
    &--half { display: grid; grid-template-columns: 1fr 1fr; gap: $space-lg;
      @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
    }
  }

  .form-group {
    label {
      display: block; font-size: $font-size-xs; text-transform: uppercase;
      letter-spacing: 0.1em; margin-bottom: $space-sm; color: $color-charcoal; font-weight: 500;
    }

    input, select, textarea {
      width: 100%; padding: $space-md $space-lg;
      border: 1px solid $color-beige; background: #fff;
      font-family: $font-sans; font-size: $font-size-base; color: $color-dark;
      transition: border-color $transition-fast;

      &:focus { outline: none; border-color: $color-gold; }
      &::placeholder { color: $color-taupe; }
    }

    textarea { resize: vertical; min-height: 150px; }
    select { appearance: none; cursor: pointer; }
  }

  .form-error { display: block; color: $color-error; font-size: $font-size-xs; margin-top: $space-xs; }
}

.alert {
  padding: $space-lg $space-xl; margin-bottom: $space-xl;
  &--success { background: rgba(45, 106, 79, .08); border: 1px solid rgba(45, 106, 79, .2); color: $color-success; }
}

.contact-info {
  &__card {
    background: $color-cream; padding: $space-2xl;
    h3 { font-size: $font-size-xl; margin-bottom: $space-xl; }
  }

  &__item {
    margin-bottom: $space-lg;
    strong { display: block; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.1em; color: $color-gold; margin-bottom: $space-xs; }
    p { margin: 0; line-height: 1.8; color: $color-charcoal; }
  }

  &__social {
    margin-top: $space-2xl;
    h4 { font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: $space-md; }
  }

  &__links {
    display: flex; gap: $space-lg;
    a { color: $color-charcoal; font-size: $font-size-sm; text-decoration: underline;
        text-underline-offset: 3px; &:hover { color: $color-gold; } }
  }
}
</style>

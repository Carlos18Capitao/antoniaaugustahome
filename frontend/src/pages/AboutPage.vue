<template>
  <div class="about-page">
    <!-- Hero -->
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">A Nossa História</span>
        <h1 class="page-hero__title">Antônio Augusta Home</h1>
        <div class="divider divider--center"></div>
      </div>
    </section>

    <!-- Story -->
    <section class="section">
      <div class="container">
        <div class="about-story">
          <div class="about-story__content">
            <h2>A Arte de Viver com Elegância</h2>
            <p>
              A Antônio Augusta Home nasceu da paixão pela criação de espaços que contam histórias.
              Cada peça que selecionamos, cada projeto que desenvolvemos, é guiado por um princípio
              fundamental: a excelência no detalhe.
            </p>
            <p>
              Com anos de experiência no universo da decoração de interiores e mobiliário de luxo,
              a nossa equipa dedica-se a transformar casas em lares extraordinários,
              onde o conforto encontra a sofisticação.
            </p>
          </div>
          <div class="about-story__image">
            <div class="about-story__placeholder">
              <span>Showroom</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Values -->
    <section class="section section--cream">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Filosofia</span>
          <h2 class="section-header__title">Os Nossos Valores</h2>
        </div>
        <div class="values-grid">
          <div class="value-card" v-for="value in values" :key="value.title">
            <div class="value-card__icon">{{ value.icon }}</div>
            <h3 class="value-card__title">{{ value.title }}</h3>
            <p class="value-card__text">{{ value.text }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Process -->
    <section class="section">
      <div class="container">
        <div class="section-header">
          <span class="section-header__subtitle">Como Trabalhamos</span>
          <h2 class="section-header__title">O Nosso Processo</h2>
        </div>
        <div class="process-steps">
          <div class="process-step" v-for="(step, i) in steps" :key="i">
            <div class="process-step__number">{{ String(i + 1).padStart(2, '0') }}</div>
            <h3 class="process-step__title">{{ step.title }}</h3>
            <p class="process-step__text">{{ step.text }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Showroom -->
    <section class="section section--dark">
      <div class="container text-center">
        <span class="section-header__subtitle" style="color: var(--color-gold);">Visite-nos</span>
        <h2 class="section-header__title" style="color: #fff;">O Nosso Showroom</h2>
        <p style="color: rgba(255,255,255,.7); max-width: 600px; margin: 1.5rem auto; line-height: 1.8;">
          Venha conhecer o nosso espaço e descubra peças exclusivas que transformam ambientes.
          A nossa equipa está disponível para o receber e ajudar a encontrar a solução perfeita para o seu lar.
        </p>
        <div class="showroom-info">
          <div class="showroom-info__item">
            <strong>Morada</strong>
            <p>Rua Example, 123<br>Luanda, Angola</p>
          </div>
          <div class="showroom-info__item">
            <strong>Horário</strong>
            <p>Seg - Sex: 10h - 19h<br>Sáb: 10h - 14h</p>
          </div>
          <div class="showroom-info__item">
            <strong>Contacto</strong>
            <p>+244 941 708 763<br>info@antonioaugustahome.pt</p>
          </div>
        </div>
        <router-link to="/contacto" class="btn btn--gold btn--lg" style="margin-top: 2rem;">Marcar Visita</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
const values = [
  { icon: '◆', title: 'Excelência', text: 'Cada detalhe é cuidadosamente pensado para superar expectativas e criar espaços verdadeiramente memoráveis.' },
  { icon: '◇', title: 'Autenticidade', text: 'Trabalhamos com materiais nobres e peças autênticas, valorizando o artesanato e a qualidade atemporal.' },
  { icon: '○', title: 'Personalização', text: 'Cada projeto é único, desenhado à medida dos sonhos e do estilo de vida de cada cliente.' },
  { icon: '□', title: 'Sustentabilidade', text: 'Comprometemo-nos com práticas responsáveis, privilegiando materiais sustentáveis e fornecedores éticos.' },
]

const steps = [
  { title: 'Consulta Inicial', text: 'Ouvimos os seus desejos, necessidades e estilo de vida para compreender a sua visão.' },
  { title: 'Conceito & Design', text: 'Desenvolvemos um conceito personalizado com moodboards, paletas e propostas de mobiliário.' },
  { title: 'Seleção & Sourcing', text: 'Selecionamos peças exclusivas de fornecedores premium nacionais e internacionais.' },
  { title: 'Implementação', text: 'Coordenamos toda a implementação, desde a entrega à instalação final, com atenção ao detalhe.' },
]
</script>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-4xl;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url('@/assets/images/about-hero.jpeg') center no-repeat;
  text-align: center;

  &__subtitle { font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.3em; color: $color-gold; display: block; margin-bottom: $space-md; }
  &__title { font-size: $font-size-5xl; margin-bottom: 0; color: #fff; }
}

.about-story {
  display: grid; grid-template-columns: 1fr 1fr; gap: $space-4xl; align-items: center;
  @media (max-width: $breakpoint-lg) { grid-template-columns: 1fr; }

  &__content {
    h2 { font-size: $font-size-3xl; margin-bottom: $space-xl; }
    p { color: $color-charcoal; line-height: 2; margin-bottom: $space-lg; font-size: $font-size-lg; }
  }

  &__image { aspect-ratio: 4/5; background: $color-cream; overflow: hidden; }
  &__placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    font-family: $font-serif; font-size: $font-size-2xl; color: $color-taupe;
  }
}

.values-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-2xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: repeat(2, 1fr); }
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.value-card {
  text-align: center; padding: $space-2xl $space-lg;

  &__icon { font-size: 2rem; color: $color-gold; margin-bottom: $space-lg; }
  &__title { font-size: $font-size-xl; margin-bottom: $space-md; }
  &__text { color: $color-warm-gray; line-height: 1.8; font-size: $font-size-sm; }
}

.process-steps {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: $space-2xl;
  @media (max-width: $breakpoint-lg) { grid-template-columns: repeat(2, 1fr); }
  @media (max-width: $breakpoint-sm) { grid-template-columns: 1fr; }
}

.process-step {
  &__number {
    font-family: $font-serif; font-size: $font-size-4xl; color: $color-beige;
    font-weight: 300; margin-bottom: $space-md;
  }
  &__title { font-size: $font-size-lg; margin-bottom: $space-sm; }
  &__text { color: $color-warm-gray; line-height: 1.8; font-size: $font-size-sm; }
}

.showroom-info {
  display: flex; justify-content: center; gap: $space-4xl; margin-top: $space-2xl; flex-wrap: wrap;

  &__item {
    text-align: center;
    strong { color: $color-gold; font-size: $font-size-xs; text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-bottom: $space-sm; }
    p { color: rgba(255,255,255,.8); line-height: 1.8; margin: 0; }
  }
}
</style>

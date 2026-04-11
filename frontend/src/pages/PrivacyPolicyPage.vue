<template>
  <div class="legal-page">
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Informação Legal</span>
        <h1 class="page-hero__title">Política de Privacidade</h1>
        <div class="divider divider--center"></div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="legal-content">
          <p class="legal-content__updated">Última atualização: 11 de abril de 2026</p>

          <h2>1. Responsável pelo Tratamento de Dados</h2>
          <p>
            A <strong>Antônio Augusta Home</strong>, com sede na Rua Example, 123, Luanda, Angola,
            é a entidade responsável pelo tratamento dos dados pessoais recolhidos através deste website.
          </p>
          <p>
            Email de contacto: <a href="mailto:info@antonioaugustahome.pt">info@antonioaugustahome.pt</a><br>
            Telefone: +244 941 708 763
          </p>

          <h2>2. Dados Pessoais Recolhidos</h2>
          <p>No âmbito da utilização deste website, poderemos recolher os seguintes dados pessoais:</p>
          <ul>
            <li><strong>Dados de identificação:</strong> nome, email, telefone — fornecidos voluntariamente através do formulário de contacto.</li>
            <li><strong>Dados de navegação:</strong> endereço IP, tipo de browser, páginas visitadas, duração da visita e dados de cookies.</li>
            <li><strong>Dados de comunicação:</strong> mensagens enviadas através do formulário de contacto ou WhatsApp.</li>
          </ul>

          <h2>3. Finalidade do Tratamento</h2>
          <p>Os dados pessoais recolhidos são utilizados para as seguintes finalidades:</p>
          <ul>
            <li>Responder a pedidos de informação e contacto;</li>
            <li>Envio de orçamentos e propostas comerciais solicitadas;</li>
            <li>Melhoria da experiência de navegação no website;</li>
            <li>Análise estatística de tráfego e comportamento no site;</li>
            <li>Cumprimento de obrigações legais.</li>
          </ul>

          <h2>4. Base Legal para o Tratamento</h2>
          <p>O tratamento dos seus dados pessoais baseia-se em:</p>
          <ul>
            <li><strong>Consentimento:</strong> quando preenche o formulário de contacto ou aceita cookies não essenciais.</li>
            <li><strong>Interesse legítimo:</strong> para análise estatística e melhoria dos nossos serviços.</li>
            <li><strong>Execução contratual:</strong> para responder a pedidos de orçamento e concretizar serviços.</li>
          </ul>

          <h2>5. Cookies</h2>
          <p>Este website utiliza cookies para melhorar a experiência de navegação. Os cookies utilizados incluem:</p>
          <ul>
            <li><strong>Cookies essenciais:</strong> necessários para o funcionamento básico do website.</li>
            <li><strong>Cookies de análise:</strong> permitem analisar o tráfego e comportamento dos visitantes (ex: Google Analytics).</li>
            <li><strong>Cookies de publicidade:</strong> utilizados para apresentar anúncios relevantes (ex: Google Ads).</li>
          </ul>
          <p>
            Pode gerir as suas preferências de cookies a qualquer momento através do banner de cookies
            ou das definições do seu browser.
          </p>

          <h2>6. Partilha de Dados</h2>
          <p>
            Os seus dados pessoais não são vendidos a terceiros. Poderão ser partilhados com:
          </p>
          <ul>
            <li>Prestadores de serviços tecnológicos (alojamento web, email);</li>
            <li>Ferramentas de análise (Google Analytics);</li>
            <li>Plataformas de publicidade (Google Ads), apenas dados anonimizados;</li>
            <li>Autoridades competentes, quando exigido por lei.</li>
          </ul>

          <h2>7. Conservação dos Dados</h2>
          <p>
            Os dados pessoais são conservados apenas pelo período necessário para as finalidades
            para as quais foram recolhidos, ou pelo período exigido por lei. Os dados de contacto
            são conservados por um máximo de 24 meses após o último contacto.
          </p>

          <h2>8. Direitos do Titular dos Dados</h2>
          <p>Nos termos da legislação aplicável, tem direito a:</p>
          <ul>
            <li><strong>Acesso:</strong> obter confirmação e acesso aos seus dados pessoais;</li>
            <li><strong>Retificação:</strong> corrigir dados inexatos ou incompletos;</li>
            <li><strong>Eliminação:</strong> solicitar a eliminação dos seus dados;</li>
            <li><strong>Portabilidade:</strong> receber os seus dados em formato estruturado;</li>
            <li><strong>Oposição:</strong> opor-se ao tratamento dos seus dados;</li>
            <li><strong>Limitação:</strong> restringir o tratamento dos seus dados.</li>
          </ul>
          <p>
            Para exercer os seus direitos, contacte-nos através de
            <a href="mailto:info@antonioaugustahome.pt">info@antonioaugustahome.pt</a>.
          </p>

          <h2>9. Segurança</h2>
          <p>
            Implementamos medidas técnicas e organizativas adequadas para proteger os seus dados
            pessoais contra acessos não autorizados, perda ou destruição acidental.
          </p>

          <h2>10. Alterações a esta Política</h2>
          <p>
            Reservamo-nos o direito de atualizar esta Política de Privacidade a qualquer momento.
            Quaisquer alterações serão publicadas nesta página com a respetiva data de atualização.
          </p>
        </div>
      </div>
    </section>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variables';

.page-hero {
  padding: calc(#{$header-height} + #{$space-4xl}) 0 $space-4xl;
  background: $color-cream;
  text-align: center;

  &__subtitle {
    font-size: $font-size-xs;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    color: $color-gold;
    display: block;
    margin-bottom: $space-md;
  }

  &__title {
    font-size: $font-size-5xl;
    margin-bottom: 0;
  }
}

.legal-content {
  max-width: $max-width-narrow;
  margin: 0 auto;

  &__updated {
    font-size: $font-size-sm;
    color: $color-taupe;
    font-style: italic;
    margin-bottom: $space-2xl;
  }

  h2 {
    font-size: $font-size-xl;
    margin-top: $space-2xl;
    margin-bottom: $space-md;
    color: $color-charcoal;
  }

  p {
    color: $color-warm-gray;
    line-height: 1.9;
    margin-bottom: $space-md;
    font-size: $font-size-base;
  }

  ul {
    list-style: none;
    padding: 0;
    margin-bottom: $space-lg;

    li {
      position: relative;
      padding-left: $space-xl;
      color: $color-warm-gray;
      line-height: 1.9;
      margin-bottom: $space-sm;
      font-size: $font-size-base;

      &::before {
        content: '—';
        position: absolute;
        left: 0;
        color: $color-gold;
      }
    }
  }

  a {
    color: $color-gold-dark;
    text-decoration: underline;
    transition: color $transition-fast;

    &:hover {
      color: $color-gold;
    }
  }
}
</style>

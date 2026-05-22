<template>
  <div class="legal-page">
    <section class="page-hero">
      <div class="container">
        <span class="page-hero__subtitle">Informação Legal</span>
        <h1 class="page-hero__title">Termos de Serviço</h1>
        <div class="divider divider--center"></div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="legal-content">
          <p class="legal-content__updated">Última atualização: 11 de abril de 2026</p>

          <h2>1. Identificação da Empresa</h2>
          <p>
            O presente website é propriedade e operado pela <strong>Antônio Augusta Home</strong>,
            com sede na Rua Example, 123, Luanda, Angola.
          </p>
          <p>
            Email: <a href="mailto:info@antonioaugustahome.pt">info@antonioaugustahome.pt</a><br>
            Telefone: +244 941 708 763
          </p>

          <h2>2. Objeto</h2>
          <p>
            Este website tem por objeto a apresentação dos serviços de decoração de interiores
            e mobiliário de luxo da Antônio Augusta Home, bem como a disponibilização de um catálogo
            de produtos e portfólio de projetos realizados.
          </p>

          <h2>3. Acesso e Utilização do Website</h2>
          <p>
            O acesso a este website é disponibilizado de forma gratuita. Ao aceder e navegar neste
            site, o utilizador aceita os presentes Termos de Serviço, comprometendo-se a respeitá-los integralmente.
          </p>
          <p>O utilizador compromete-se a:</p>
          <ul>
            <li>Não utilizar o website para fins ilegais ou não autorizados;</li>
            <li>Não tentar aceder a áreas restritas do website;</li>
            <li>Não transmitir vírus, malware ou qualquer código malicioso;</li>
            <li>Não reproduzir, duplicar ou explorar comercialmente os conteúdos sem autorização.</li>
          </ul>

          <h2>4. Propriedade Intelectual</h2>
          <p>
            Todos os conteúdos presentes neste website — incluindo textos, imagens, fotografias,
            logótipos, design gráfico e software — são propriedade da Antônio Augusta Home ou dos
            respetivos titulares, e estão protegidos por direitos de propriedade intelectual.
          </p>
          <p>
            É proibida a reprodução, distribuição, transformação ou comunicação pública dos conteúdos
            sem autorização prévia e expressa da Antônio Augusta Home.
          </p>

          <h2>5. Informação sobre Produtos e Preços</h2>
          <p>
            Os produtos apresentados no catálogo online são meramente informativos. As fotografias
            podem não reproduzir fielmente as cores e dimensões reais dos produtos.
          </p>
          <p>
            Os preços e a disponibilidade dos produtos estão sujeitos a alteração sem aviso prévio.
            Para informações atualizadas, contacte-nos diretamente.
          </p>

          <h2>6. Formulário de Contacto</h2>
          <p>
            Ao submeter o formulário de contacto, o utilizador autoriza a Antônio Augusta Home
            a utilizar os dados fornecidos exclusivamente para responder ao pedido efetuado,
            nos termos da nossa
            <router-link to="/politica-privacidade">Política de Privacidade</router-link>.
          </p>

          <h2>7. Limitação de Responsabilidade</h2>
          <p>
            A Antônio Augusta Home envidará todos os esforços para manter o website atualizado
            e em funcionamento. No entanto, não garante:
          </p>
          <ul>
            <li>A disponibilidade contínua e ininterrupta do website;</li>
            <li>A ausência total de erros técnicos;</li>
            <li>Que os conteúdos estejam permanentemente atualizados.</li>
          </ul>
          <p>
            A Antônio Augusta Home não se responsabiliza por eventuais danos decorrentes
            do uso ou impossibilidade de uso deste website.
          </p>

          <h2>8. Links Externos</h2>
          <p>
            Este website pode conter links para sites de terceiros. A Antônio Augusta Home
            não é responsável pelo conteúdo, políticas de privacidade ou práticas desses websites.
          </p>

          <h2>9. Legislação Aplicável</h2>
          <p>
            Os presentes Termos de Serviço são regidos pela legislação da República de Angola.
            Para a resolução de qualquer litígio decorrente da utilização deste website,
            será competente o foro da comarca de Luanda.
          </p>

          <h2>10. Alterações aos Termos</h2>
          <p>
            A Antônio Augusta Home reserva-se o direito de modificar estes Termos de Serviço
            a qualquer momento. As alterações entram em vigor imediatamente após a sua publicação
            nesta página.
          </p>
        </div>
      </div>
    </section>
  </div>
</template>

<style lang="scss" scoped>
@use '@/assets/scss/variables' as *;

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

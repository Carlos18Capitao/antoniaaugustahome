import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/pages/HomePage.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
    meta: { title: 'Antônio Augusta Home — Decoração Premium' },
  },
  {
    path: '/catalogo',
    name: 'catalog',
    component: () => import('@/pages/CatalogPage.vue'),
    meta: { title: 'Catálogo — Antônio Augusta Home' },
  },
  {
    path: '/catalogo/:slug',
    name: 'product',
    component: () => import('@/pages/ProductPage.vue'),
    meta: { title: 'Produto — Antônio Augusta Home' },
  },
  {
    path: '/projetos',
    name: 'projects',
    component: () => import('@/pages/ProjectsPage.vue'),
    meta: { title: 'Projetos — Antônio Augusta Home' },
  },
  {
    path: '/projetos/:slug',
    name: 'project',
    component: () => import('@/pages/ProjectDetailPage.vue'),
    meta: { title: 'Projeto — Antônio Augusta Home' },
  },
  {
    path: '/sobre',
    name: 'about',
    component: () => import('@/pages/AboutPage.vue'),
    meta: { title: 'Sobre — Antônio Augusta Home' },
  },
  {
    path: '/contacto',
    name: 'contact',
    component: () => import('@/pages/ContactPage.vue'),
    meta: { title: 'Contacto — Antônio Augusta Home' },
  },
  {
    path: '/politica-privacidade',
    name: 'privacy-policy',
    component: () => import('@/pages/PrivacyPolicyPage.vue'),
    meta: { title: 'Política de Privacidade — Antônio Augusta Home' },
  },
  {
    path: '/termos-servico',
    name: 'terms-of-service',
    component: () => import('@/pages/TermsOfServicePage.vue'),
    meta: { title: 'Termos de Serviço — Antônio Augusta Home' },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0, behavior: 'smooth' }
  },
})

router.beforeEach((to) => {
  document.title = to.meta.title || 'Antônio Augusta Home'
})

export default router

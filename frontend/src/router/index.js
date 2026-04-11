import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Public pages
import HomePage from '@/pages/HomePage.vue'

const routes = [
  // ===== PUBLIC =====
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

  // ===== ADMIN =====
  {
    path: '/admin/login',
    name: 'admin-login',
    component: () => import('@/pages/admin/LoginPage.vue'),
    meta: { title: 'Admin Login', guest: true },
  },
  {
    path: '/admin',
    component: () => import('@/pages/admin/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'admin-dashboard',
        component: () => import('@/pages/admin/DashboardPage.vue'),
        meta: { title: 'Dashboard' },
      },
      {
        path: 'produtos',
        name: 'admin-products',
        component: () => import('@/pages/admin/ProductsPage.vue'),
        meta: { title: 'Gerir Produtos' },
      },
      {
        path: 'produtos/novo',
        name: 'admin-product-create',
        component: () => import('@/pages/admin/ProductFormPage.vue'),
        meta: { title: 'Novo Produto' },
      },
      {
        path: 'produtos/:id/editar',
        name: 'admin-product-edit',
        component: () => import('@/pages/admin/ProductFormPage.vue'),
        meta: { title: 'Editar Produto' },
      },
      {
        path: 'categorias',
        name: 'admin-categories',
        component: () => import('@/pages/admin/CategoriesPage.vue'),
        meta: { title: 'Gerir Categorias' },
      },
      {
        path: 'projetos',
        name: 'admin-projects',
        component: () => import('@/pages/admin/AdminProjectsPage.vue'),
        meta: { title: 'Gerir Projetos' },
      },
      {
        path: 'projetos/novo',
        name: 'admin-project-create',
        component: () => import('@/pages/admin/ProjectFormPage.vue'),
        meta: { title: 'Novo Projeto' },
      },
      {
        path: 'projetos/:id/editar',
        name: 'admin-project-edit',
        component: () => import('@/pages/admin/ProjectFormPage.vue'),
        meta: { title: 'Editar Projeto' },
      },
      {
        path: 'leads',
        name: 'admin-leads',
        component: () => import('@/pages/admin/LeadsPage.vue'),
        meta: { title: 'Contactos / Leads' },
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0, behavior: 'smooth' }
  },
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title || 'Antônio Augusta Home'

  if (to.meta.requiresAuth) {
    const authStore = useAuthStore()
    if (!authStore.isAuthenticated) {
      return next({ name: 'admin-login' })
    }
  }

  if (to.meta.guest) {
    const authStore = useAuthStore()
    if (authStore.isAuthenticated) {
      return next({ name: 'admin-dashboard' })
    }
  }

  next()
})

export default router

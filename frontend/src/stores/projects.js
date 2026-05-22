import { defineStore } from 'pinia'
import { ref } from 'vue'

const BASE = import.meta.env.BASE_URL

async function loadProjects() {
  const res = await fetch(BASE + 'data/projects.json')
  const json = await res.json()
  return json.data
}

export const useProjectStore = defineStore('projects', () => {
  const projects = ref([])
  const project = ref(null)
  const featuredProjects = ref([])
  const loading = ref(false)

  async function fetchProjects() {
    loading.value = true
    try {
      projects.value = await loadProjects()
    } finally {
      loading.value = false
    }
  }

  async function fetchProject(slug) {
    loading.value = true
    try {
      const data = await loadProjects()
      project.value = data.find(p => p.slug === slug) || null
    } finally {
      loading.value = false
    }
  }

  async function fetchFeatured() {
    const data = await loadProjects()
    featuredProjects.value = data.filter(p => p.is_featured)
  }

  return {
    projects,
    project,
    featuredProjects,
    loading,
    fetchProjects,
    fetchProject,
    fetchFeatured,
  }
})

import { defineStore } from 'pinia'
import { ref } from 'vue'
import { projectApi } from '@/api'

export const useProjectStore = defineStore('projects', () => {
  const projects = ref([])
  const project = ref(null)
  const featuredProjects = ref([])
  const loading = ref(false)

  async function fetchProjects(params = {}) {
    loading.value = true
    try {
      const { data } = await projectApi.list(params)
      projects.value = data
    } finally {
      loading.value = false
    }
  }

  async function fetchProject(slug) {
    loading.value = true
    try {
      const { data } = await projectApi.show(slug)
      project.value = data.data
    } finally {
      loading.value = false
    }
  }

  async function fetchFeatured() {
    const { data } = await projectApi.featured()
    featuredProjects.value = data.data
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

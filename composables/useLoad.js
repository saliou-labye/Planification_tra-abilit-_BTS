/** Charge des données au montage de la page : { data, loading, error, reload }. */
export const useLoad = (fn) => {
  const data = ref(null)
  const loading = ref(true)
  const error = ref('')

  const reload = async () => {
    loading.value = true
    error.value = ''
    try {
      data.value = await fn()
    } catch (e) {
      error.value = e.message
    } finally {
      loading.value = false
    }
  }

  onMounted(reload)
  return { data, loading, error, reload }
}
export const useAction = () => {
  const toast = useToast()
  const busy = ref(false)

  const run = async (fn, message = 'Enregistré.') => {
    busy.value = true
    try {
      const res = await fn()
      toast.ok(message)
      return res ?? true
    } catch (e) {
      toast.err(e.message)
      return false
    } finally {
      busy.value = false
    }
  }

  return { busy, run }
}
export const useToast = () => {
  const items = useState('toasts', () => [])
  const push = (message, type) => {
    const id = Date.now() + Math.random()
    items.value.push({ id, message, type })
    setTimeout(() => { items.value = items.value.filter((t) => t.id !== id) }, 4000)
  }
  return { items, ok: (m) => push(m, 'ok'), err: (m) => push(m, 'err') }
}
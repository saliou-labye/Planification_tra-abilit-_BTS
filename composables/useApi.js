/** Appel de l'API Laravel avec le jeton Sanctum. Lève une Error avec un message lisible. */
export const useApi = () => {
  const { public: cfg } = useRuntimeConfig()
  const token = useCookie('token', { maxAge: 60 * 60 * 24 * 7 })

  return async (url, options = {}) => {
    try {
      return await $fetch(url, {
        baseURL: cfg.apiBase,
        ...options,
        headers: {
          Accept: 'application/json',
          ...(token.value ? { Authorization: `Bearer ${token.value}` } : {}),
          ...options.headers,
        },
      })
    } catch (e) {
      if (e?.response?.status === 401 && token.value) {
        token.value = null
        useState('user').value = null
        useState('role').value = null
        await navigateTo('/connexion')
      }
      const premiereErreur = e?.data?.errors ? Object.values(e.data.errors).flat()[0] : null
      throw new Error(premiereErreur || e?.data?.message || 'Impossible de joindre le serveur.')
    }
  }
}
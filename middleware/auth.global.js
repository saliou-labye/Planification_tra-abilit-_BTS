const PUBLIC = ['/', '/connexion', '/inscription']

export default defineNuxtRouteMiddleware(async (to) => {
  const { token, role, fetchMe } = useAuth()

  // Pages publiques : un utilisateur connecté est renvoyé vers son espace
  if (PUBLIC.includes(to.path)) {
    if (token.value && to.path !== '/') {
      if (!role.value) { try { await fetchMe() } catch { return } }
      if (role.value) return navigateTo(ROLE_HOME[role.value])
    }
    return
  }

  if (!token.value) return navigateTo('/connexion')

  if (!role.value) {
    try { await fetchMe() } catch { return navigateTo('/connexion') }
  }

  // Chaque rôle reste dans son espace
  const base = ROLE_HOME[role.value]
  if (!base) return navigateTo('/connexion')
  if (to.path !== base && !to.path.startsWith(base + '/')) return navigateTo(base)
})
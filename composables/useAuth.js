export const useAuth = () => {
  const api = useApi()
  const token = useCookie('token', { maxAge: 60 * 60 * 24 * 7 })
  const user = useState('user', () => null)
  const role = useState('role', () => null)
  const profilId = useState('profilId', () => null)

  const fetchMe = async () => {
    const me = await api('/me')
    user.value = me.utilisateur
    role.value = me.role
    profilId.value = me.profil_id
  }

  const ouvrir = async (res) => {
    token.value = res.token
    await fetchMe()
    return ROLE_HOME[role.value] || '/connexion'
  }

  const login = async (form) => ouvrir(await api('/login', { method: 'POST', body: form }))
  const register = async (form) => ouvrir(await api('/register', { method: 'POST', body: form }))

  const logout = async () => {
    try { await api('/logout', { method: 'POST' }) } catch { /* jeton déjà invalide */ }
    token.value = null
    user.value = null
    role.value = null
    profilId.value = null
    await navigateTo('/connexion')
  }

  return { token, user, role, profilId, fetchMe, login, register, logout }
}
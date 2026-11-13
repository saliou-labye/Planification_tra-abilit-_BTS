export const fmtDate = (d) =>
  d ? new Date(String(d).replace(' ', 'T')).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }) : '—'

export const fmtDateLong = (d) =>
  d ? new Date(String(d).slice(0, 10) + 'T00:00:00').toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' }) : '—'

export const fmtMoney = (n) => `${Number(n || 0).toLocaleString('fr-FR')} FCFA`
export const fmtKg = (n) => `${Number(n || 0).toLocaleString('fr-FR', { maximumFractionDigits: 1 })} kg`
export const nomComplet = (u) => (u ? `${u.prenom_utilisateur} ${u.nom_utilisateur}` : '—')
export const initiales = (u) => (u ? `${u.prenom_utilisateur?.[0] || ''}${u.nom_utilisateur?.[0] || ''}`.toUpperCase() : '?')

/** Mois au format attendu par l'API : MM/AAAA. */
export const moisCle = (d = new Date()) => `${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()}`

/** Date du jour au format AAAA-MM-JJ (heure locale). */
export const today = () => {
  const d = new Date()
  return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`
}

export const jour = (d) => String(d || '').slice(0, 10)

export const WASTE_TYPES = ['Plastique', 'Verre', 'Papier et carton', 'Métal', 'Organique']
export const ANOMALIES = ['Dépôt sauvage', 'Bac débordant', 'Voie bloquée', 'Caniveau bouché', 'Voie dégradée']
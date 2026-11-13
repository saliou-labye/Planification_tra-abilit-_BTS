export const ROLE_HOME = {
  client: '/client',
  collecteur: '/collecteur',
  controlleur: '/controleur',
  service_trie: '/tri',
  partenaire: '/partenaire',
  admin: '/admin',
}

export const ROLE_LABEL = {
  client: 'Client',
  collecteur: 'Collecteur',
  controlleur: 'Contrôleur',
  service_trie: 'Service de tri',
  partenaire: 'Partenaire',
  admin: 'Administrateur',
}

/** Menu latéral de chaque rôle. */
export const NAV = {
  client: [
    { to: '/client', label: 'Accueil', icon: 'home' },
    { to: '/client/calendrier', label: 'Calendrier', icon: 'calendar' },
    { to: '/client/paiements', label: 'Paiements', icon: 'card' },
    { to: '/client/dechets', label: 'Mes déchets', icon: 'recycle' },
    { to: '/client/signalements', label: 'Signaler', icon: 'alert' },
    { to: '/client/reclamations', label: 'Réclamations', icon: 'chat' },
    { to: '/client/evaluations', label: 'Noter', icon: 'star' },
    { to: '/client/profil', label: 'Profil', icon: 'user' },
  ],
  collecteur: [
    { to: '/collecteur', label: 'Ma journée', icon: 'home' },
    { to: '/collecteur/collectes', label: 'Mes collectes', icon: 'truck' },
    { to: '/collecteur/evaluations', label: 'Mes évaluations', icon: 'star' },
    { to: '/collecteur/profil', label: 'Profil', icon: 'user' },
  ],
  controlleur: [
    { to: '/controleur', label: 'Signalements', icon: 'alert' },
    { to: '/controleur/historique', label: 'Historique', icon: 'list' },
    { to: '/controleur/profil', label: 'Profil', icon: 'user' },
  ],
  service_trie: [
    { to: '/tri', label: 'Collectes', icon: 'truck' },
    { to: '/tri/dechets', label: 'Déchets déclarés', icon: 'recycle' },
    { to: '/tri/stock', label: 'Stock', icon: 'box' },
    { to: '/tri/transactions', label: 'Transactions', icon: 'swap' },
    { to: '/tri/profil', label: 'Profil', icon: 'user' },
  ],
  partenaire: [
    { to: '/partenaire', label: 'Déchets disponibles', icon: 'box' },
    { to: '/partenaire/transactions', label: 'Mes transactions', icon: 'swap' },
    { to: '/partenaire/profil', label: 'Profil', icon: 'user' },
  ],
  admin: [
    { to: '/admin', label: 'Tableau de bord', icon: 'chart' },
    { to: '/admin/collectes', label: 'Collectes', icon: 'truck' },
    { to: '/admin/affectations', label: 'Affectations', icon: 'map' },
    { to: '/admin/quartiers', label: 'Quartiers', icon: 'map' },
    { to: '/admin/vehicules', label: 'Véhicules', icon: 'truck' },
    { to: '/admin/utilisateurs', label: 'Utilisateurs', icon: 'users' },
    { to: '/admin/paiements', label: 'Paiements', icon: 'card' },
    { to: '/admin/reclamations', label: 'Réclamations', icon: 'chat' },
    { to: '/admin/signalements', label: 'Signalements', icon: 'alert' },
  ],
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/** Tableau de bord de l'administrateur (OP10 : pilotage). */
class DashboardController extends Controller
{
    public function __invoke()
    {
        $mois = now()->format('m/Y');
        $clients = DB::table('client')->count();
        $payes = DB::table('payement')->where('mois_concerne', $mois)->where('statut_pay', 'Payé')->count();

        return [
            'collectes_par_statut' => DB::table('collecte')->select('statut_collec', DB::raw('COUNT(*) as total'))->groupBy('statut_collec')->get(),
            'collectes_du_mois' => DB::table('collecte')->whereMonth('date_prevue', now()->month)->whereYear('date_prevue', now()->year)->count(),
            'taux_paiement_mois' => $clients ? round($payes * 100 / $clients, 1) : 0,
            'reclamations_ouvertes' => DB::table('reclamation')->where('statut', '!=', 'Clôturée')->count(),
            'signalements_a_traiter' => DB::table('signalement_voie')->whereIn('statut_signal', ['Signalé', 'En vérification'])->count(),
            'dechets_tries_kg' => (float) DB::table('dechet_trie')->whereIn('statut_vente', ['Acheté', 'Vendu', 'Transformé'])->sum('poids_reel'),
            'note_moyenne_collecteurs' => round((float) DB::table('evaluation')->avg('note_obte'), 2),
        ];
    }
}
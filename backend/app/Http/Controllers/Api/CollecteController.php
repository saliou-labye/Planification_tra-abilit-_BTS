<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collecte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Planification, réalisation et réception des collectes */
class CollecteController extends Controller
{
    private const AVEC = ['quartier', 'collecteur.utilisateur', 'vehicule', 'serviceTrie.utilisateur'];

    /** Le client voit le calendrier de son quartier ; le collecteur, ses collectes. */
    public function index(Request $request)
    {
        $u = $request->user();
        $id = $u->profilId();
        $q = Collecte::with(self::AVEC)->orderBy('date_prevue');

        match ($u->role()) {
            'client' => $q->whereIn('id_quart', DB::table('reside')->where('id_client', $id)->pluck('id_quart')),
            'collecteur' => $q->where('id_collecteur', $id),
            'service_trie' => $q->where('id_servicet', $id),
            default => null,
        };

        if ($request->filled('statut')) {
            $q->where('statut_collec', $request->statut);
        }

        return $q->get();
    }

    public function show(Collecte $collecte)
    {
        return $collecte->load(self::AVEC);
    }

    /**planification des collects */
    public function store(Request $request)
    {
        $d = $request->validate([
            'date_prevue' => 'required|date|after_or_equal:today',
            'id_quart' => 'required|exists:quartier,id_quart',
            'id_collecteur' => 'required|exists:collecteur,id_collecteur',
            'id_vehicu' => 'required|exists:vehicule,id_vehicu',
            'id_servicet' => 'required|exists:service_trie,id_servicet',
        ]);

        $aff = DB::table('affecte')->where('id_collecteur', $d['id_collecteur'])->orderByDesc('date_')->first();
        if (!$aff || (int) $aff->id_quart !== (int) $d['id_quart']) {
            return response()->json(['message' => 'Ce collecteur n’est pas affecté à ce quartier.'], 422);
        }

        $occupe = Collecte::where('date_prevue', $d['date_prevue'])
            ->where(fn ($q) => $q->where('id_collecteur', $d['id_collecteur'])->orWhere('id_vehicu', $d['id_vehicu']))
            ->exists();
        if ($occupe) {
            return response()->json(['message' => 'Collecteur ou véhicule déjà occupé à cette date.'], 422);
        }

        $collecte = Collecte::create($d + ['statut_collec' => 'Planifiée']);

        return response()->json($collecte->load(self::AVEC), 201);
    }

    /** démarrage par le collecteur. */
    public function demarrer(Request $request, Collecte $collecte)
    {
        abort_unless($collecte->id_collecteur === $request->user()->profilId(), 403, 'Ce n’est pas votre collecte.');
        return $this->changer($collecte, 'Planifiée', 'En cours');
    }

    /** confirmation (la date effective est enregistrée automatiquement,). */
    public function confirmer(Request $request, Collecte $collecte)
    {
        abort_unless($collecte->id_collecteur === $request->user()->profilId(), 403, 'Ce n’est pas votre collecte.');
        return $this->changer($collecte, 'En cours', 'Effectuée', ['date_effect' => now()->toDateString()]);
    }

    /** réception par le service de tri */
    public function receptionner(Request $request, Collecte $collecte)
    {
        return $this->changer($collecte, 'Effectuée', 'Réceptionnée', ['id_servicet' => $request->user()->profilId()]);
    }

    public function annuler(Collecte $collecte)
    {
        return $this->changer($collecte, 'Planifiée', 'Annulée');
    }

    private function changer(Collecte $c, string $de, string $vers, array $extra = [])
    {
        abort_unless($c->statut_collec === $de, 422, "La collecte doit être au statut « $de ».");
        $c->update(['statut_collec' => $vers] + $extra);

        return $c->fresh()->load(self::AVEC);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DechetTrie;
use Illuminate\Http\Request;

/** Valorisation des déchets triés (OP8). */
class DechetTrieController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $q = DechetTrie::with('client.utilisateur')->orderByDesc('id_dechet');

        if ($u->role() === 'client') {
            $q->where('id_client', $u->profilId());
        }
        if ($request->filled('statut')) {
            $q->where('statut_vente', $request->statut);
        }

        return $q->get();
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'type_dechet' => 'required|string|max:50',
            'poid_estime' => 'required|numeric|gt:0',
        ]);

        $dechet = DechetTrie::create($d + ['id_client' => $request->user()->profilId(), 'statut_vente' => 'Déclaré']);

        return response()->json($dechet, 201);
    }

    /** Pesée réelle, décision d'achat et orientation (vente ou fumier). */
    public function controler(Request $request, DechetTrie $dechet)
    {
        $d = $request->validate([
            'poids_reel' => 'required|numeric|min:0',
            'decision' => 'required|in:accepter,refuser',
        ]);
        abort_unless($dechet->statut_vente === 'Déclaré', 422, 'Ce déchet a déjà été contrôlé.');

        $base = ['poids_reel' => $d['poids_reel'], 'id_servicet' => $request->user()->profilId()];

        if ($d['decision'] === 'refuser') {
            $dechet->update($base + ['statut_vente' => 'Refusé']);
        } else {
            $fumier = str_contains(mb_strtolower($dechet->type_dechet), 'organique');
            $dechet->update($base + [
                'statut_vente' => $fumier ? 'Transformé' : 'Acheté',
                'destination' => $fumier ? 'Fumier' : 'Vente',
            ]);
        }

        return $dechet->fresh();
    }

    /** Stock disponible à la vente, par type de déchet. */
    public function stock()
    {
        return DechetTrie::selectRaw('type_dechet, SUM(poids_reel) as quantite')
            ->where('statut_vente', 'Acheté')
            ->where('destination', 'Vente')
            ->whereNull('id_transac')
            ->groupBy('type_dechet')
            ->get();
    }
}
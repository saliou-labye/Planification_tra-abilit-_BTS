<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DechetTrie;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Vente aux partenaires (OP9, RG-15, RG-16). */
class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $q = Transaction::with(['partenaire.utilisateur', 'serviceTrie.utilisateur'])->orderByDesc('date_traitement');

        match ($u->role()) {
            'partenaire' => $q->where('id_partenaire', $u->profilId()),
            'service_trie' => $q->where('id_servicet', $u->profilId()),
            default => null,
        };

        return $q->get();
    }

    /** Validée par le service de tri après réception du paiement du partenaire. */
    public function store(Request $request)
    {
        $d = $request->validate([
            'id_partenaire' => 'required|exists:partenaire,id_partenaire',
            'type_dechet' => 'required|string',
            'quantite_achetee' => 'required|numeric|gt:0',
            'prix_unitaire' => 'required|numeric|gt:0',
        ]);
        $idTri = $request->user()->profilId();

        $transaction = DB::transaction(function () use ($d, $idTri) {
            $lots = DechetTrie::where('statut_vente', 'Acheté')
                ->where('destination', 'Vente')
                ->whereNull('id_transac')
                ->where('type_dechet', $d['type_dechet'])
                ->orderBy('id_dechet')
                ->lockForUpdate()
                ->get();

            abort_if($lots->sum('poids_reel') < $d['quantite_achetee'], 422, 'Stock insuffisant pour cette quantité.');

            $t = Transaction::create([
                'quantite_achetee' => $d['quantite_achetee'],
                'montant_payer' => round($d['quantite_achetee'] * $d['prix_unitaire'], 2),
                'date_traitement' => now(),
                'id_servicet' => $idTri,
                'id_partenaire' => $d['id_partenaire'],
            ]);

            $cumul = 0;
            foreach ($lots as $lot) {
                if ($cumul >= $d['quantite_achetee']) {
                    break;
                }
                $lot->update(['id_transac' => $t->id_transac, 'statut_vente' => 'Vendu']);
                $cumul += $lot->poids_reel;
            }

            return $t;
        });

        return response()->json($transaction->load(['partenaire.utilisateur']), 201);
    }
}
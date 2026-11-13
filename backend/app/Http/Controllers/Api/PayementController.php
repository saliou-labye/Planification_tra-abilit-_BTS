<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Payement;
use Illuminate\Http\Request;

/** Paiement mensuel simulé (OP5, RG-09). */
class PayementController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $q = Payement::with('client.utilisateur')->orderByDesc('date_pay');

        if ($u->role() === 'client') {
            $q->where('id_client', $u->profilId());
        }
        if ($request->filled('mois')) {
            $q->where('mois_concerne', $request->mois);
        }

        return $q->get();
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'mois_concerne' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{4}$/'],
            'montant' => 'required|numeric|min:1',
        ]);
        $idClient = $request->user()->profilId();

        if (Payement::where('id_client', $idClient)->where('mois_concerne', $d['mois_concerne'])->exists()) {
            return response()->json(['message' => 'Ce mois est déjà payé.'], 422);
        }

        $p = Payement::create($d + ['id_client' => $idClient, 'statut_pay' => 'Payé', 'date_pay' => now()]);

        return response()->json($p, 201);
    }

    /** Clients n'ayant pas payé le mois demandé (par défaut : le mois en cours). */
    public function impayes(Request $request)
    {
        $mois = $request->query('mois', now()->format('m/Y'));
        $payes = Payement::where('mois_concerne', $mois)->where('statut_pay', 'Payé')->pluck('id_client');

        return Client::with('utilisateur')->whereNotIn('id_client', $payes)->get();
    }
}
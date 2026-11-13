<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collecte;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Évaluation des collecteurs (OP6). */
class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $q = Evaluation::with(['client.utilisateur', 'collecteur.utilisateur'])->orderByDesc('date_evalue');

        if ($u->role() === 'collecteur') {
            $q->where('id_collecteur', $u->profilId());
        }

        return ['moyenne' => round((clone $q)->avg('note_obte') ?? 0, 2), 'evaluations' => $q->get()];
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'id_collecteur' => 'required|exists:collecteur,id_collecteur',
            'note_obte' => 'required|integer|between:1,5',
            'commentaire' => 'nullable|string',
        ]);
        $idClient = $request->user()->profilId();

        // On n'évalue que le collecteur d'une collecte effectuée dans son quartier.
        $quartiers = DB::table('reside')->where('id_client', $idClient)->pluck('id_quart');
        $ok = Collecte::whereIn('id_quart', $quartiers)
            ->where('id_collecteur', $d['id_collecteur'])
            ->whereIn('statut_collec', ['Effectuée', 'Réceptionnée'])
            ->exists();
        if (!$ok) {
            return response()->json(['message' => 'Aucune collecte effectuée par ce collecteur dans votre quartier.'], 422);
        }

        return response()->json(Evaluation::create($d + ['id_client' => $idClient, 'date_evalue' => now()]), 201);
    }
}
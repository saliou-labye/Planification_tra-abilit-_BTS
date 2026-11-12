<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use Illuminate\Http\Request;

/** Affectation d'un collecteur à un quartier (OP2, RG-04). */
class AffectationController extends Controller
{
    public function index()
    {
        return Affectation::query()
            ->join('quartier', 'quartier.id_quart', '=', 'affecte.id_quart')
            ->join('collecteur', 'collecteur.id_collecteur', '=', 'affecte.id_collecteur')
            ->join('utilisateur', 'utilisateur.id_utilisateur', '=', 'collecteur.id_utilisateur')
            ->orderByDesc('affecte.date_')
            ->get(['affecte.*', 'quartier.nom_quart', 'utilisateur.nom_utilisateur', 'utilisateur.prenom_utilisateur']);
    }

    /** La dernière affectation d'un collecteur fait foi : un seul quartier à la fois. */
    public function store(Request $request)
    {
        $d = $request->validate([
            'id_quart' => 'required|exists:quartier,id_quart',
            'id_collecteur' => 'required|exists:collecteur,id_collecteur',
            'date_' => 'required|date',
        ]);

        Affectation::updateOrCreate(
            ['id_quart' => $d['id_quart'], 'id_collecteur' => $d['id_collecteur'], 'date_' => $d['date_']],
            []
        );

        return response()->json($d, 201);
    }
}
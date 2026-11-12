<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SignalementVoie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Signalements de voie publique (OP7). */
class SignalementController extends Controller
{
    /** Transitions autorisées par le contrôleur. */
    private const TRANSITIONS = [
        'En vérification' => ['Confirmé', 'Rejeté'],
        'Confirmé' => ['Résolu'],
    ];

    public function index(Request $request)
    {
        $u = $request->user();
        $q = SignalementVoie::with(['client.utilisateur', 'controlleur.utilisateur'])->orderByDesc('id_signal');

        if ($u->role() === 'client') {
            $q->where('id_client', $u->profilId());
        }
        if ($request->filled('statut')) {
            $q->where('statut_signal', $request->statut);
        }

        return $q->get();
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            'type_anomalie' => 'required|string',
        ]);

        $s = SignalementVoie::create($d + ['id_client' => $request->user()->profilId(), 'statut_signal' => 'Signalé']);

        return response()->json($s, 201);
    }

    public function prendreEnCharge(Request $request, SignalementVoie $signalement)
    {
        abort_unless($signalement->statut_signal === 'Signalé', 422, 'Ce signalement est déjà pris en charge.');
        $signalement->update(['statut_signal' => 'En vérification', 'id_controlleur' => $request->user()->profilId()]);

        return $signalement;
    }

    public function changerStatut(Request $request, SignalementVoie $signalement)
    {
        $d = $request->validate(['statut' => ['required', Rule::in(['Confirmé', 'Rejeté', 'Résolu'])]]);
        abort_unless($signalement->id_controlleur === $request->user()->profilId(), 403, 'Ce n’est pas votre signalement.');

        $permis = self::TRANSITIONS[$signalement->statut_signal] ?? [];
        abort_unless(in_array($d['statut'], $permis, true), 422, 'Changement de statut impossible.');

        $signalement->update(['statut_signal' => $d['statut']]);

        return $signalement;
    }
}
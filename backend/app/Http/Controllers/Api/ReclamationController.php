<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Réclamations (OP6). */
class ReclamationController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $q = Reclamation::with(['client.utilisateur', 'collecte'])->orderByDesc('date_soumi');

        if ($u->role() === 'client') {
            $q->where('id_client', $u->profilId());
        }
        if ($request->filled('statut')) {
            $q->where('statut', $request->statut);
        }

        return $q->get();
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'description' => 'required|string',
            'id_collect' => 'nullable|exists:collecte,id_collect',
        ]);

        $r = Reclamation::create($d + [
            'id_client' => $request->user()->profilId(),
            'statut' => 'Ouverte',
            'date_soumi' => now(),
        ]);

        return response()->json($r, 201);
    }

    public function update(Request $request, Reclamation $reclamation)
    {
        $d = $request->validate(['statut' => ['required', Rule::in(['Ouverte', 'En traitement', 'Clôturée'])]]);
        $reclamation->update($d);

        return $reclamation;
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/** Gestion des comptes par l'administrateur (OP1). */
class UtilisateurController extends Controller
{
    public function index(Request $request)
{
    $liste = Utilisateur::orderBy('nom_utilisateur')->get()->map(fn ($u) => $u->toArray() + [
        'role' => $u->role(),
        'profil_id' => $u->profilId(),   // id_collecteur, id_servicet, etc.
    ]);

    if ($request->filled('role')) {
        $liste = $liste->where('role', $request->role)->values();
    }

    return $liste;
}

    public function store(Request $request)
    {
        $d = $request->validate([
            'role' => ['required', Rule::in(array_keys(Utilisateur::PROFILS))],
            'nom_utilisateur' => 'required|string|max:50',
            'prenom_utilisateur' => 'required|string|max:50',
            'tel' => 'required|string|max:15',
            'email' => 'required|email|max:100|unique:utilisateur,email',
            'mot_de_passe' => 'required|string|min:8',
        ]);

        $user = DB::transaction(function () use ($d) {
            $user = Utilisateur::create(collect($d)->except('role')->all());
            DB::table($d['role'])->insert(['id_utilisateur' => $user->id_utilisateur]);
            return $user;
        });

        return response()->json($user->toArray() + ['role' => $d['role']], 201);
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();
        return response()->noContent();
    }
}
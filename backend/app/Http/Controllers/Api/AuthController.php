<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** Inscription d'un client . */
    public function register(Request $request)
    {
        $d = $request->validate([
            'nom_utilisateur' => 'required|string|max:50',
            'prenom_utilisateur' => 'required|string|max:50',
            'tel' => 'required|string|max:15',
            'email' => 'required|email|max:100|unique:utilisateur,email',
            'mot_de_passe' => 'required|string|min:8',
            'id_quart' => 'required|exists:quartier,id_quart',
        ]);

        $user = DB::transaction(function () use ($d) {
            $user = Utilisateur::create(collect($d)->except('id_quart')->all());
            $idClient = DB::table('client')->insertGetId(['id_utilisateur' => $user->id_utilisateur], 'id_client');
            DB::table('reside')->insert(['id_quart' => $d['id_quart'], 'id_client' => $idClient]);
            return $user;
        });

        return response()->json($this->reponse($user), 201);
    }

    public function login(Request $request)
    {
        $d = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|string',
        ]);

        $user = Utilisateur::where('email', $d['email'])->first();

        if (!$user || !Hash::check($d['mot_de_passe'], $user->mot_de_passe)) {
            throw ValidationException::withMessages(['email' => 'Identifiants incorrects.']);
        }

        return $this->reponse($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté.']);
    }

    public function me(Request $request)
    {
        $u = $request->user();
        return ['utilisateur' => $u, 'role' => $u->role(), 'profil_id' => $u->profilId()];
    }

    private function reponse(Utilisateur $user): array
    {
        return [
            'token' => $user->createToken('api')->plainTextToken,
            'utilisateur' => $user,
            'role' => $user->role(),
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    public $timestamps = false;

    protected $fillable = ['nom_utilisateur', 'prenom_utilisateur', 'tel', 'email', 'mot_de_passe'];
    protected $hidden = ['mot_de_passe'];
    protected $casts = ['mot_de_passe' => 'hashed'];

    /** Table de rôle => colonne identifiant du profil. */
    public const PROFILS = [
        'admin' => 'id_admin',
        'client' => 'id_client',
        'collecteur' => 'id_collecteur',
        'controlleur' => 'id_controlleur',
        'partenaire' => 'id_partenaire',
        'service_trie' => 'id_servicet',
    ];

    private ?array $profilCache = null;

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /** Retourne ['role' => ..., 'id' => ...] ou null. */
    private function profil(): ?array
    {
        if ($this->profilCache !== null) {
            return $this->profilCache ?: null;
        }
        foreach (self::PROFILS as $table => $cle) {
            $id = DB::table($table)->where('id_utilisateur', $this->id_utilisateur)->value($cle);
            if ($id) {
                return $this->profilCache = ['role' => $table, 'id' => $id];
            }
        }
        $this->profilCache = [];
        return null;
    }

    public function role(): ?string
    {
        return $this->profil()['role'] ?? null;
    }

    public function profilId(): ?int
    {
        return $this->profil()['id'] ?? null;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Controlleur extends Model
{
    protected $table = 'controlleur';
    protected $primaryKey = 'id_controlleur';
    public $timestamps = false;
    protected $fillable = ['id_utilisateur'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function signalements()
    {
        return $this->hasMany(SignalementVoie::class, 'id_controlleur', 'id_controlleur');
    }
}
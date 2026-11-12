<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id_client';
    public $timestamps = false;
    protected $fillable = ['id_utilisateur'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function payements()
    {
        return $this->hasMany(Payement::class, 'id_client', 'id_client');
    }
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'id_client', 'id_client');
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_client', 'id_client');
    }
    public function signalements()
    {
        return $this->hasMany(SignalementVoie::class, 'id_client', 'id_client');
    }
    public function dechets()
    {
        return $this->hasMany(DechetTrie::class, 'id_client', 'id_client');
    }
    public function quartiers()
    {
        return $this->belongsToMany(Quartier::class, 'reside', 'id_client', 'id_quart');
    }
}
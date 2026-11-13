<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collecteur extends Model
{
    protected $table = 'collecteur';
    protected $primaryKey = 'id_collecteur';
    public $timestamps = false;
    protected $fillable = ['id_utilisateur'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function collectes()
    {
        return $this->hasMany(Collecte::class, 'id_collecteur', 'id_collecteur');
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_collecteur', 'id_collecteur');
    }
    public function quartiers()
    {
        return $this->belongsToMany(Quartier::class, 'affecte', 'id_collecteur', 'id_quart')->withPivot('date_');
    }
}
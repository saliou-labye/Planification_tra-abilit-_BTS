<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collecte extends Model
{
    protected $table = 'collecte';
    protected $primaryKey = 'id_collect';
    public $timestamps = false;
    protected $fillable = ['date_prevue', 'date_effect', 'statut_collec', 'id_servicet', 'id_collecteur', 'id_vehicu', 'id_quart'];

    public function quartier()
    {
        return $this->belongsTo(Quartier::class, 'id_quart', 'id_quart');
    }
    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class, 'id_collecteur', 'id_collecteur');
    }
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'id_vehicu', 'id_vehicu');
    }
    public function serviceTrie()
    {
        return $this->belongsTo(ServiceTrie::class, 'id_servicet', 'id_servicet');
    }
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'id_collect', 'id_collect');
    }
}
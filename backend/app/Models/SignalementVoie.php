<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignalementVoie extends Model
{
    protected $table = 'signalement_voie';
    protected $primaryKey = 'id_signal';
    public $timestamps = false;
    protected $fillable = ['longitude', 'latitude', 'type_anomalie', 'statut_signal', 'id_controlleur', 'id_client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
    public function controlleur()
    {
        return $this->belongsTo(Controlleur::class, 'id_controlleur', 'id_controlleur');
    }
}
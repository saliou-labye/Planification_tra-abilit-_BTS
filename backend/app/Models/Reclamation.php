<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $table = 'reclamation';
    protected $primaryKey = 'id_reclam';
    public $timestamps = false;
    protected $fillable = ['description', 'date_soumi', 'statut', 'id_collect', 'id_client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
    public function collecte()
    {
        return $this->belongsTo(Collecte::class, 'id_collect', 'id_collect');
    }
}
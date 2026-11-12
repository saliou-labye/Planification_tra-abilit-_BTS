<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    protected $table = 'quartier';
    protected $primaryKey = 'id_quart';
    public $timestamps = false;
    protected $fillable = ['nom_quart', 'description'];

    public function collectes()
    {
        return $this->hasMany(Collecte::class, 'id_quart', 'id_quart');
    }
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'reside', 'id_quart', 'id_client');
    }
    public function collecteurs()
    {
        return $this->belongsToMany(Collecteur::class, 'affecte', 'id_quart', 'id_collecteur')->withPivot('date_');
    }
}
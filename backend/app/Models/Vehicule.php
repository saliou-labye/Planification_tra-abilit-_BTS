<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicule';
    protected $primaryKey = 'id_vehicu';
    public $timestamps = false;
    protected $fillable = ['immatriculation', 'type_vehicule'];

    public function collectes()
    {
        return $this->hasMany(Collecte::class, 'id_vehicu', 'id_vehicu');
    }
}
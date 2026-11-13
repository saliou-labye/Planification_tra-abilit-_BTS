<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    protected $table = 'payement';
    protected $primaryKey = 'id_paiy';
    public $timestamps = false;
    protected $fillable = ['montant', 'mois_concerne', 'date_pay', 'statut_pay', 'id_client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
}
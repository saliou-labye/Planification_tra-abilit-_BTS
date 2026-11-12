<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id_transac';
    public $timestamps = false;
    protected $fillable = ['quantite_achetee', 'montant_payer', 'date_traitement', 'id_servicet', 'id_partenaire'];

    public function serviceTrie()
    {
        return $this->belongsTo(ServiceTrie::class, 'id_servicet', 'id_servicet');
    }
    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class, 'id_partenaire', 'id_partenaire');
    }
    public function dechets()
    {
        return $this->hasMany(DechetTrie::class, 'id_transac', 'id_transac');
    }
}
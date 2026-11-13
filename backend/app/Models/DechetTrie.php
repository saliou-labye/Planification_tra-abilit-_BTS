<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DechetTrie extends Model
{
    protected $table = 'dechet_trie';
    protected $primaryKey = 'id_dechet';
    public $timestamps = false;
    protected $fillable = ['type_dechet', 'poid_estime', 'statut_vente', 'poids_reel', 'destination', 'id_transac', 'id_client', 'id_servicet'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
    public function serviceTrie()
    {
        return $this->belongsTo(ServiceTrie::class, 'id_servicet', 'id_servicet');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transac', 'id_transac');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTrie extends Model
{
    protected $table = 'service_trie';
    protected $primaryKey = 'id_servicet';
    public $timestamps = false;
    protected $fillable = ['id_utilisateur'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function collectes()
    {
        return $this->hasMany(Collecte::class, 'id_servicet', 'id_servicet');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_servicet', 'id_servicet');
    }
    public function dechets()
    {
        return $this->hasMany(DechetTrie::class, 'id_servicet', 'id_servicet');
    }
}
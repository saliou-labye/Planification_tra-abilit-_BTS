<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluation';
    protected $primaryKey = 'id_evalu';
    public $timestamps = false;
    protected $fillable = ['date_evalue', 'commentaire', 'note_obte', 'id_client', 'id_collecteur'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }
    public function collecteur()
    {
        return $this->belongsTo(Collecteur::class, 'id_collecteur', 'id_collecteur');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    protected $table = 'partenaire';
    protected $primaryKey = 'id_partenaire';
    public $timestamps = false;
    protected $fillable = ['id_utilisateur'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_partenaire', 'id_partenaire');
    }
}
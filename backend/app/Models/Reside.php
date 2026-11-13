<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reside extends Model
{
    protected $table = 'reside';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_quart', 'id_client'];
}
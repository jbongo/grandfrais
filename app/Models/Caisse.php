<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;
    protected $guarded =[];

    /*
    * Retourne les transactions de la caisse
    */

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded =[];

    /*
    * Retourne l'achat lié a la transaction
    */
    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    /*
    * Retourne la vente lié a la transaction
    */

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    /*
    * Retourne la depense lié a la transaction
    */

    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }

    /*
    * Retourne la caisse lié a la transaction
    */

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }
}
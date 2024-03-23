<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Retourne le produit vendu
     */
    public function produit()
    {
      
        $produit = Produit::find($this->produit_id);
        return $produit;
        // return $this->belongsTo(Produit::class);
    }

    /**
     * Retourne le client ayant effectué la vente
     */
    public function client()
    {
        // return $this->belongsTo(Client::class);
    }
}
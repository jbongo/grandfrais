<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

    protected $guarded =[];
    protected $dates = ['date_prestation'];

    // protected $casts  = ['date_achat' => 'date'];

    /*
    ** retourne le contact fournisseur 
    */
    public function fournisseur()
    {
        return $this->belongsTo(Contact::class, 'fournisseur_id');
    }

    /*
    * retourne le produit lié
    */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
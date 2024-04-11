<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'date_vente' => 'date',
    ];


    /**
     * Retourne le client ayant effectué la vente
     */
    public function client()
    {
        // return $this->belongsTo(Client::class);
    }

    /*
   * Retourne les produits liés à la vente
   */
   
  public function produits(){

    return $this->belongsToMany(Produit::class)->withPivot('id','quantite','prix_unitaire','prix_total','prix_unitaire_modifie');
  } 


}
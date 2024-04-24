<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded =[];

    /*
    * Ajouter une transaction
    */
public static function ajouter($data)
    {
        $transaction = new Transaction();
        $transaction->operation = $data['operation'];
        $transaction->type = $data['type'];
        $transaction->date_transaction = $data['date_transaction'];
        $transaction->montant = $data['montant'];
        $transaction->description = $data['description'];
        $transaction->caisse_id = $data['caisse_id'];
        $transaction->user_id = $data['user_id'];
        $transaction->resource_id = $data['resource_id'];
        $transaction->solde = $data['solde'];
        $transaction->save();

        return $transaction;

    }

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
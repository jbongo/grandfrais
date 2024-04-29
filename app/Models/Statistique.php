<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    /*
    * Retourne le CA 
    */
    public function chiffreAffaire($dateDeb, $dateFin){

        $caAchats = $this->montantAchats($dateDeb, $dateFin);
        $caVentes = $this->montantVentes($dateDeb, $dateFin);
        $caDepenses = $this->montantDepenses($dateDeb, $dateFin);

        return $caDepenses;
    }

    /*
    * Retourne le bénéfice net
    */

    public function beneficeNet($dateDeb, $dateFin){

       $benefice = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->sum('benefice');

        return $benefice;
    }

    /*
    * Retourne le montant des achats
    */
    public function montantAchats($dateDeb, $dateFin){

        $caAchats = Achat::whereBetween('date_achat', [$dateDeb, $dateFin])->where('archive', false)->sum('prix_total');
        return $caAchats;
    }

    /*
    * Retourne le montant des ventes
    */
    public function montantVentes($dateDeb, $dateFin){

        $caVentes = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->sum('montant');
        return $caVentes;
    }

    /*
    * Retourne le montant des dépenses
    */
    public function montantDepenses($dateDeb, $dateFin){
        
        $caDepenses = Depense::whereBetween('date_depense', [$dateDeb, $dateFin])->where('archive', false)->sum('montant');
        return $caDepenses;
    }

}
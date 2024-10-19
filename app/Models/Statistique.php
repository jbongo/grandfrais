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
        
        $caVentes = $this->montantVentes($dateDeb, $dateFin);
        return $caVentes;
    }

    /*
    * Retourne les CA mensuels
    */
    public function chiffreAffaireMensuels($annee) {
        
        //  ######## Calcul CA Sur l'année ##########
        for ($i=1; $i <= 12 ; $i++) {                
                       
            $month = $i < 10 ? "0$i" : $i;
            $date_deb = $annee.'-'.$month.'-01';
            $date_fin = $annee.'-'.$month.'-31';
            
            // $ca[$i] = $this->chiffreAffaire($date_deb, $date_fin);
            $ca[] = $this->chiffreAffaire($date_deb, $date_fin);

        }

        return $ca;

    }

    /*
    * Retourne les benefices nets mensuels
    */
    public function beneficeNetMensuels($annee) {

        //  ######## Calcul CA Sur l'année ##########
        for ($i=1; $i <= 12 ; $i++) {                
                       
            $month = $i < 10 ? "0$i" : $i;
            $date_deb = $annee.'-'.$month.'-01';
            $date_fin = $annee.'-'.$month.'-31';
            
            // $benefices[$i] = $this->beneficeNet($date_deb, $date_fin);
            $benefices[] = $this->beneficeNet($date_deb, $date_fin);

        }

        return $benefices;
    }

    /**
     * Retourne les achats mensuels
     */
    
     public function achatsMensuels($annee) {

        //  ######## Calcul CA Sur l'année ##########
        for ($i=1; $i <= 12 ; $i++) {                
                       
            $month = $i < 10 ? "0$i" : $i;
            $date_deb = $annee.'-'.$month.'-01';
            $date_fin = $annee.'-'.$month.'-31';
            
            $achats[] = $this->montantAchats($date_deb, $date_fin);

        }

        return $achats;
     }
    /*
    * Retourne les dépenses mensuelles
    */

    public function depensesMensuelles($annee) {

        //  ######## Calcul CA Sur l'année ##########
        for ($i=1; $i <= 12 ; $i++) {                
                       
            $month = $i < 10 ? "0$i" : $i;
            $date_deb = $annee.'-'.$month.'-01';
            $date_fin = $annee.'-'.$month.'-31';
            
            $depenses[] = $this->montantDepenses($date_deb, $date_fin);

        }

        return $depenses;
    }

    /*
    * Retourne le bénéfice net de tous les produits
    */
    public function beneficeNet($dateDeb, $dateFin){

        // $benefice = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->sum('benefice');

        // réccuperer les ids des ventes sur la date de debut et de fin
        $ventes = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->get();
        $idsVentes = $ventes->pluck('id');

        $produitGlace = Produit::where('nom', 'Glace')->first();    
        $benefices = ProduitVente::whereIn('vente_id', $idsVentes)->where('produit_id','<>', $produitGlace->id)->sum('benefice');

  
        return $benefices;
    }

    /*
    * Retourne le bénéfice net d'un produit
    */
    public function beneficeNetProduit( $dateDeb, $dateFin,$idProduit){

        // réccuperer les ids des ventes sur la date de debut et de fin
        $ventes = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->get();
        $idsVentes = $ventes->pluck('id');

       
        $benefices = ProduitVente::whereIn('vente_id', $idsVentes)->where('produit_id', $idProduit)->sum('benefice');

        return $benefices;
      
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

    /*
    * Retourne le classement des meilleurs produits vendues par bénéfice
    */
    public function meilleursVentes($dateDeb, $dateFin){

        $ventes = Vente::whereBetween('date_vente', [$dateDeb, $dateFin])->where('archive', false)->get();

        // dd($ventes);
    }

}
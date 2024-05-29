<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caisse;
use App\Models\Statistique;

class DashboardController extends Controller
{
    //
    
    public function  index($annee = null){
        
        // $annee = 2023;
   
        $stat = new Statistique();
           
        
        if( !is_null($annee)){
            $annee_n = $annee;
    
        }else{
            $annee_n = date('Y');
        }

        $ca_n = $stat->chiffreAffaireMensuels($annee_n);
        $benefices_n = $stat->beneficeNetMensuels($annee_n);
        dd($benefices_n);

        
        $caisse = Caisse::where('est_principale', true)->first();
        $montantCaisse = $caisse->solde;

        // CA du jour
        $caJour = $stat->chiffreAffaire(date('Y-m-d'), date('Y-m-d'));

        // CA du mois
        $date = date('Y-m');
        $caMois = $stat->chiffreAffaire($date.'-01', $date.'-31');

        // CA de l'annee
        $caAnnee = $stat->chiffreAffaire(date('Y').'-01-01', date('Y').'-12-31');

        // benefice du mois
        $beneficeMois = $stat->beneficeNet($date.'-01', $date.'-31');
        dd($beneficeMois);

       
        return view('dashboard'); 
    }
}
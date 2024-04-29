<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caisse;
use App\Models\Statistique;

class DashboardController extends Controller
{
    //
    
    public function  index(){
        
        $caisse = Caisse::where('est_principale', true)->first();
        $montantCaisse = $caisse->solde;

        $stat = new Statistique();
        // CA du jour
        $caJour = $stat->chiffreAffaire(date('Y-m-d'), date('Y-m-d'));

        // CA du mois
        $date = date('Y-m');
        $caMois = $stat->chiffreAffaire($date.'-01', $date.'-31');

        // CA de l'annee
        $caAnnee = $stat->chiffreAffaire(date('Y').'-01-01', date('Y').'-12-31');

        // benefice du mois
        $beneficeMois = $stat->beneficeNet($date.'-01', $date.'-31');
        // dd($beneficeMois);

       
        return view('dashboard'); 
    }
}
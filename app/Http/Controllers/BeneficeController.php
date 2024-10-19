<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistique;
use App\Models\Produit;


class BeneficeController extends Controller
{
    /**
     * Retourne la page de calcul des bénéfices
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produits = Produit::where('archive', false)->get();
        return view('benefices.index' , compact('produits'));
    }

    /*
     * Calcul des bénéfices d'un article ou tous les articles sur une plage de date
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function benefices(Request $request)
    {
        $data = $request->all();
        
        $date_debut = $data['date_debut'] ?? date('Y-m-d');
        $date_fin = $data['date_fin'] ?? date('Y-m-d');
        $produit_id = $data['produit_id'] ?? null;

        $stat = new Statistique();
      

        if($produit_id == null){
            return $stat->beneficeNet($date_debut, $date_fin);
        }
        else{
            return $stat->beneficeNetProduit($date_debut, $date_fin, $produit_id);
        }

    }
}

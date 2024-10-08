<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
use App\Models\ProduitVente;
use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::where('archive', false)->get();
        return view('vente.index', compact('produits'));
    }

    /**
     * Display a listing of the resource.
     */
    public function archives()
    {
        $produits = Produit::where('archive', true)->get();
        return view('vente.archive', compact('produits'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::where('archive', false)->orderBy('nom')->get();
        return view('vente.add', compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        unset($params["date_vente"]) ;
        unset($params["_token"]) ;
        
        
        $ligneVentes = array_chunk($params, 3);

        $vente = new Vente();
         
        $vente->user_id = Auth::user()->id;
        $vente->numero = Vente::count() + 1;
        $vente->date_vente = $request->date_vente;
       
        $vente->save();

        $prix_global = 0;
        $description = "";
        $caisse = Caisse::where('est_principale', true)->first();
        $benefice_total = 0;

        foreach ($ligneVentes as $ligne) {
            
            // 0 => produit_id, 1 => quantité, 2 => prix_unitaire
 
            $produit = Produit::find($ligne[0]);
            $quantite = $ligne[1];
            $prix_total = $ligne[2];
            $prix_unitaire = $prix_total / $quantite;

            $prix_unitaire_modifie = $produit->prix_vente_ttc != $prix_unitaire ? true : false;

            $prix_global += $prix_total;
            $description_prix_total = $prix_unitaire_modifie == false ? $prix_total. " €" : "<span style='color:red;'>" . $prix_total . " €</span>";
            $description .= $produit->nom . " : ". $description_prix_total . "  |  ";

            $benefice = ($prix_unitaire - $produit->prix_achat_ttc) * $quantite;
            $benefice_total += $benefice;
            $produit->ventes()->attach($vente->id, ['quantite' => $quantite, 'prix_unitaire' => $prix_unitaire, 'prix_total' => $prix_total, 'benefice' => $benefice]);

             // MAJ Stock

             $produit->quantite_stock -= $quantite;

             $produit->save();
 
             // MAJ Caisse
             if($caisse != null){
                 $caisse->solde += $prix_total;
                 $caisse->save();
             }

        }

        $vente->montant = $prix_global;
        $vente->description = $description;     
        $vente->benefice = $benefice_total;     
        $vente->save();

        // Enregistrer Transaction
        $data = [
            'operation' => 'vente',
            'type' => 'crédit',
            'date_transaction' => $request->date_vente,
            'montant' => $prix_global,
            'description' => "Vente n° ".$vente->numero,
            'caisse_id' => $caisse->id,
            'user_id' => Auth::user()->id,
            'resource_id' => $vente->id,
            'solde' => $caisse?->solde,
        ];
    
        Transaction::ajouter($data);

        return redirect()->route('vente.index')->with('ok', 'Vente enregistrée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show($vente)
    {

        $vente = Vente::where('id', Crypt::decrypt($vente))->first();
        return view('vente.show', compact('vente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($vente_id)
    {
        $vente = Vente::where('id', Crypt::decrypt($vente_id))->first();
        $produits = Produit::where('archive', false)->orderBy('nom')->get();
        return view('vente.edit', compact('vente', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vente_id)
    {

        $vente = Vente::where('id', Crypt::decrypt($vente_id))->first();

        $params = $request->all();
        unset($params["date_vente"]) ;
        unset($params["_token"]) ;
        
        
        $ligneVentes = array_chunk($params, 4);


        $vente->date_vente = $request->date_vente;
        $vente->save();

        $prix_global = 0;
        $benefice_total = 0;
        $description = "";
        $ancien_prix = $vente->montant;

       

        // dd($ligneVentes);

        foreach ($ligneVentes as $ligne) {
            
            // 0 => produit_id, 1 => prix_unitaire, 2 => quantite , 3 => pivot_id


            $pivot = $ligne[3] == null ? null : ProduitVente::find($ligne[3]);
            
            if($pivot != null){
                $vente->produits()->detach($pivot->produit_id);
            }


             // 0 => produit_id, 1 => quantité, 2 => prix_unitaire
 
             $produit = Produit::find($ligne[0]);
             $quantite = $ligne[1];
             $prix_total = $ligne[2];
             $prix_unitaire = $prix_total / $quantite;
            
            $prix_unitaire_modifie = $produit->prix_vente_ttc != $prix_unitaire ? true : false;

            $prix_global += $prix_total;
            $description_prix_total = $prix_unitaire_modifie == false ? $prix_total. " €" : "<span style='color:red;'>" . $prix_total . " €</span>";
            $description .= $produit->nom . " : ". $description_prix_total . "  |  ";

            $benefice = ($prix_unitaire - $produit->prix_achat_ttc) * $quantite;
            $benefice_total += $benefice;
            $produit->ventes()->attach($vente->id, ['quantite' => $quantite, 'prix_unitaire' => $prix_unitaire, 'prix_total' => $prix_total, 'prix_unitaire_modifie' => $prix_unitaire_modifie, 'benefice' => $benefice]);

            $caisse = Caisse::where('est_principale', true)->first();

            // MAJ Stock
            if($pivot != null){

                $produit->quantite_stock = $produit->quantite_stock + $pivot->quantite - $quantite;
                $produit->save();

                // MAJ Caisse
                if($caisse != null){
                    $caisse->solde = $caisse->solde - $pivot->prix_total + $prix_total;
                    $caisse->save();
                }

            }else{
                
                $produit->quantite_stock = $produit->quantite_stock  - $quantite;
                $produit->save();

                // MAJ Caisse
                if($caisse != null){
                    $caisse->solde = $caisse->solde + $prix_total;
                    $caisse->save();
                }

            }
        }

        $vente->montant = $prix_global;
        $vente->description = $description; 
        $vente->benefice = $benefice_total;     
        $vente->save();

        // Enregistrer Transaction
        $data = [
            'operation' => 'vente',
            'type' => 'crédit',
            'date_transaction' => $request->date_vente,
            'montant' => $prix_global,
            'description' => "Modification Vente n° ".$vente->numero." ancien montant: ".$ancien_prix." => nouveau montant: ".$prix_global,
            'caisse_id' => $caisse->id,
            'user_id' => Auth::user()->id,
            'resource_id' => $vente->id,
            'solde' => $caisse?->solde,
        ];
    
        Transaction::ajouter($data);

        return redirect()->route('vente.index')->with('ok', 'Vente modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        //
    }

    /**
     * Archive the specified resource from storage.
     */
    public function archive($vente_id)
    {

        $vente = Vente::where('id', Crypt::decrypt($vente_id))->first();
        $vente->archive = true;
        $vente->save();
        return redirect()->route('vente.index')->with('ok', 'Vente archivée avec succès');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function unarchive($vente_id)
    {
        $vente = Vente::where('id', Crypt::decrypt($vente_id))->first();
       
        $vente->archive = false;
        $vente->save();
        return redirect()->route('vente.index')->with('ok', 'Vente restaurée avec succès');
    }
}
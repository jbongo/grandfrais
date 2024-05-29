<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::where('archive', false)->get();
        $contacts = Contact::where([['archive', false], ['type', 'Fournisseur']])->get();
        $caisses = Caisse::where('archive', false)->get();

        return view('achat.index', compact('produits', 'contacts', 'caisses'));
    }

    

    /**
     * Ajouter un achat
     */
    public function store(Request $request)
    {


        $request->validate([
            'produit_id' => 'required',
            'quantite' => 'required',
            'date_achat' => 'required',
            'prix_total' => 'required',

        ]);
        
    
      
        $prix_total = $request->prix_total;
        $quantite = $request->quantite;
        $prix_unitaire =  round($prix_total / $quantite,2);
        $prix_total_revient = $prix_total + $request->autres_charges;
        $prix_unitaire_revient = round($prix_total_revient / $quantite,2);

        $achat = new Achat();
        $achat->produit_id = $request->produit_id;
        $achat->caisse_id = $request->caisse_id;
        $achat->fournisseur_id = $request->fournisseur_id;
        $achat->user_id = Auth::user()->id;
        $achat->quantite = $request->quantite;
        $achat->prix_unitaire = $prix_unitaire;
        $achat->prix_total = $prix_total;
        $achat->autres_charges = $request->autres_charges;
        $achat->prix_total_revient = $prix_total_revient;
        $achat->prix_unitaire_revient = $prix_unitaire_revient;
        $achat->date_achat = $request->date_achat;

        $achat->save();

        // Mettre à jour le Stock
        $produit = Produit::find($request->produit_id);
        $produit->quantite_stock = $produit->quantite_stock + $quantite;
        $produit->save();

         // MAJ Caisse
         $caisse = Caisse::where('id', $request->caisse_id)->first();
         if($caisse != null){
             $caisse->solde -= $prix_total_revient;
             $caisse->save();
         }


        // Enregistrer Transaction
        $data = [
            'operation' => 'achat',
            'type' => 'crédit',
            'date_transaction' => $request->date_achat,
            'montant' => $prix_total_revient,
            'description' => "Achat - ".$produit->nom,
            'caisse_id' => $request->caisse_id,
            'user_id' => Auth::user()->id,
            'resource_id' => $achat->id,
            'solde' => $caisse?->solde,
        ];

        Transaction::ajouter($data);

        return redirect()->route('achat.index')->with('ok', 'Achat effectué ');

    }

    

    /**
     * Modifier un achat
     */
    public function update(Request $request, $achat_id)
    {

        $request->validate([
            'produit_id' => 'required',
            'quantite' => 'required',
            'date_achat' => 'required',
            'prix_total' => 'required',

        ]);
        $achat = Achat::find(Crypt::decrypt($achat_id));

        $ancienne_quantite  = $achat->quantite;
        $ancien_prix = $achat->prix_total_revient;
        $ancienne_caisse_id = $achat->caisse_id;

        $prix_total = $request->prix_total;
        $quantite = $request->quantite;
        $prix_unitaire =  round($prix_total / $quantite,2);
        $prix_total_revient = $prix_total + $request->autres_charges;
        $prix_unitaire_revient = round($prix_total_revient / $quantite,2);

      
        $achat->produit_id = $request->produit_id;
        $achat->fournisseur_id = $request->fournisseur_id;
        $achat->caisse_id = $request->caisse_id;
        $achat->quantite = $request->quantite;
        $achat->prix_unitaire = $prix_unitaire;
        $achat->prix_total = $prix_total;
        $achat->autres_charges = $request->autres_charges;
        $achat->prix_total_revient = $prix_total_revient;
        $achat->prix_unitaire_revient = $prix_unitaire_revient;
        $achat->date_achat = $request->date_achat;

        $achat->save();

        // Mettre à jour le Stock
        $produit = Produit::find($request->produit_id);
        $produit->quantite_stock = $produit->quantite_stock - $ancienne_quantite + $quantite;
        $produit->save();

        // MAJ Caisse
      
        $ancienne_caisse = Caisse::where('id', $ancienne_caisse_id)->first();
        if($ancienne_caisse != null){          
            $ancienne_caisse->solde += $ancien_prix;
            $ancienne_caisse->save();
        }

        $nouvelle_caisse = Caisse::where('id', $request->caisse_id)->first();
  
        $nouvelle_caisse->solde -= $prix_total_revient;
        $nouvelle_caisse->save();


        // Enregistrer Transaction
        $data = [
            'operation' => 'achat',
            'type' => 'crédit',
            'date_transaction' => $request->date_achat,
            'montant' => $prix_total_revient,
            'description' => "Modification Achat - ".$produit->nom. " - Quantite : ".$ancienne_quantite." -> ".$quantite." - Prix total: ".$ancien_prix." -> ".$prix_total_revient,
            'caisse_id' => $request->caisse_id,
            'user_id' => Auth::user()->id,
            'resource_id' => $achat->id,
            'solde' => $nouvelle_caisse?->solde,
        ];
        
        Transaction::ajouter($data);

        return redirect()->route('achat.index')->with('ok', 'Achat modifié ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achat $achat)
    {
        //
    }
}
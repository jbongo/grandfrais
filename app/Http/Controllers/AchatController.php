<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\Contact;
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


        return view('achat.index', compact('produits', 'contacts'));
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

        $achat = new Achat();
        $achat->produit_id = $request->produit_id;
        $achat->fournisseur_id = $request->fournisseur_id;
        $achat->user_id = Auth::user()->id;
        $achat->quantite = $request->quantite;
        $achat->prix_unitaire = $prix_unitaire;
        $achat->prix_total = $prix_total;
        $achat->date_achat = $request->date_achat;

        $achat->save();

        // Mettre à jour le Stock
        $produit = Produit::find($request->produit_id);
        $produit->quantite_stock = $produit->quantite_stock + $quantite;
        $produit->save();

        return redirect()->route('achat.index')->with('ok', 'Achat effectué ');

    }

    /**
     * Display the specified resource.
     */
    public function show(Achat $achat)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achat $achat)
    {
        //
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

        $prix_total = $request->prix_total;
        $quantite = $request->quantite;
        $prix_unitaire =  round($prix_total / $quantite,2);

      
        $achat->produit_id = $request->produit_id;
        $achat->fournisseur_id = $request->fournisseur_id;
        $achat->quantite = $request->quantite;
        $achat->prix_unitaire = $prix_unitaire;
        $achat->prix_total = $prix_total;
        $achat->date_achat = $request->date_achat;

        $achat->save();

        // Mettre à jour le Stock
        $produit = Produit::find($request->produit_id);
        $produit->quantite_stock = $produit->quantite_stock - $ancienne_quantite + $quantite;
        $produit->save();

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
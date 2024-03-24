<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::where('archive', false)->get();
        
        return view('achat.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'produit_id' => 'required',
            'quantite' => 'required',
            'date_achat' => 'required',
            'prix_unitaire' => 'required',

        ]);
        
      
        $prix_unitaire = $request->prix_unitaire;
        $quantite = $request->quantite;
        $prix_total = $prix_unitaire * $quantite;

        $achat = new Achat();
        $achat->produit_id = $request->produit_id;
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

        return redirect()->route('achats.index')->with('ok', 'Achat effectué ');

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
        $achat = Achat::find(Crypt::decrypt($achat_id));

        $request->validate([
            'produit_id' => 'required',
            'quantite' => 'required',
            'date_achat' => 'required',
            'prix_unitaire' => 'required',

        ]);

        $achat->produit_id = $request->produit_id;
        $achat->quantite = $request->quantite;
        $achat->prix_unitaire = $prix_unitaire;
        $achat->prix_total = $prix_total;
        $achat->date_achat = $request->date_achat;

        $achat->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achat $achat)
    {
        //
    }
}
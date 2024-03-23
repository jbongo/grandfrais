<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Produit;
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
            'date_vente' => 'required',
        ]);
        
        $produit = Produit::find($request->produit_id);
        $prix = $produit->prix_vente_ttc;
        $prix_total = $prix * $request->quantite;

        


        $vente = new Vente();
        $vente->produit_id = $request->produit_id;
        $vente->user_id = Auth::user()->id;
        $vente->quantite = $request->quantite;
        $vente->prix_unitaire = $prix;
        $vente->prix_total = $prix_total;
        $vente->date_vente = $request->date_vente;

        $vente->save();

        return redirect()->route('vente.index')->with('ok', 'Vente enregistrée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vente $vente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vente_id)
    {

     
        
        $request->validate([
            'produit_id' => 'required',
            'quantite' => 'required',
            'date_vente' => 'required',
        ]);
        
        $produit = Produit::find($request->produit_id);
      

        $vente = vente::where('id', Crypt::decrypt($vente_id))->first();


        if($vente->produit_id != $request->produit_id){
            $prix = $produit->prix_vente_ttc;
        }else{
            $prix = $vente->prix_unitaire;
        }

        $vente->produit_id = $request->produit_id;
        $vente->quantite = $request->quantite;
        $vente->prix_total = $prix * $vente->quantite;
        $vente->date_vente = $request->date_vente;

        $vente->save();

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
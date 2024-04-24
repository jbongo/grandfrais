<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Crypt, Auth;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caisses = Caisse::where('archive', false)->get();
        
        return view('caisse.index', compact('caisses'));
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
            "nom" => "required",
            "solde" => "required",
        ]);

        Caisse::create($request->all());

        return redirect()->route('caisse.index')->with('ok', 'Caisse ajoutée');
    }

    /**
     * Display the specified resource.
     */
    public function show($caisse_id)
    {
        $caisse = Caisse::find(Crypt::decrypt($caisse_id));

        return view('caisse.show', compact('caisse'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $caisse_id)
    {
        $request->validate([
            "nom" => "required",
            "solde" => "required",
        ]);

        $caisse = Caisse::find(Crypt::decrypt($caisse_id));

        $caisse->update($request->all());

        return redirect()->route('caisse.index')->with('ok', 'Caisse modifié');

    }
    
    /**
     * Opération dépots / retraits
     */
    public function operation(Request $request,  $caisse_id, $operation)
    {
        $request->validate([
            "montant" => "required",
        ]);

        $caisse = Caisse::find(Crypt::decrypt($caisse_id));

        if ($operation == 'dépot') {
            $caisse->solde += $request->montant;
        } elseif ($operation == 'retrait') {
            $caisse->solde -= $request->montant;
        }

         // Enregistrer Transaction
         $data = [
            'operation' => $operation,
            'type' => $operation == 'dépot' ? 'crédit' : 'débit',
            'date_transaction' => $request->date_operation,
            'montant' => $request->montant,
            'description' => "$operation caisse ",
            'caisse_id' => Crypt::decrypt($caisse_id),
            'user_id' => Auth::user()->id,
            'resource_id' => Crypt::decrypt($caisse_id),
            'solde' => $caisse?->solde,
        ];
        
        Transaction::ajouter($data);


        $caisse->save();

        return redirect()->route('caisse.index')->with('ok', 'Caisse modifié');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caisse $caisse)
    {
        //
    }
}
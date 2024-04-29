<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Typedepense;
use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typedepenses = Typedepense::where('archive', false)->get();
        $caisses = Caisse::where('archive', false)->get();

        return view('depense.index', compact('typedepenses', 'caisses'));
    }

  
    /**
     * Display a listing of the resource.
     */
    public function archives()
    {
        $typedepenses = Typedepense::where('archive', false)->get();
        return view('depense.archives', compact('typedepenses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
            
            $depense = new Depense();
            $depense->user_id = auth()->user()->id;
            $depense->typedepense_id = $request->typedepense_id;
            $depense->caisse_id = $request->caisse_id;
            $depense->details = $request->details;
            $depense->montant = $request->montant;
            $depense->date_depense = $request->date_depense;
            $depense->save();

            // MAJ CAISSE
            $caisse = Caisse::find($request->caisse_id);
            $caisse->solde = $caisse->solde - $request->montant;
            $caisse->update();

            // Enregistrer Transaction
            $data = [
                'operation' => 'dépense',
                'type' => 'débit',
                'date_transaction' => $request->date_depense,
                'montant' => $request->montant,
                'description' => "Ajout Dépense : ".$depense->typedepense->type,
                'caisse_id' => $request->caisse_id,
                'user_id' => Auth::user()->id,
                'resource_id' => $depense->id,
                'solde' => $caisse?->solde,
            ];
        
            Transaction::ajouter($data);
    
            return redirect()->route('depense.index')->with('success', 'Dépense ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        //
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $depense_id)
    {
        $depense = Depense::find(Crypt::decrypt($depense_id));
        $depense->details = $request->details;
        $depense->typedepense_id = $request->typedepense_id;

        $caisse_id = $depense->caisse_id;
        $ancien_montant = $depense->montant;

        $depense->caisse_id = $request->caisse_id;


        $depense->montant = $request->montant;
        $depense->date_depense = $request->date_depense;
        $depense->save();

        
        // MAJ CAISSE
        if($caisse_id != $depense->caisse_id){
            $nouvelle_caisse = Caisse::find($request->caisse_id);
            $ancienne_caisse = Caisse::find($caisse_id);
            $nouvelle_caisse->solde = $nouvelle_caisse->solde - $request->montant;
            $ancienne_caisse->solde = $ancienne_caisse->solde + $ancien_montant;
         
            $nouvelle_caisse->update();
            $ancienne_caisse->update();
            $caisse = $nouvelle_caisse;

        }else{
            $caisse = Caisse::find($request->caisse_id);
            $caisse->solde = $caisse->solde + $ancien_montant - $request->montant;
            $caisse->update();

        }

         // Enregistrer Transaction
         $data = [
            'operation' => 'dépense',
            'type' => 'débit',
            'date_transaction' => $request->date_depense,
            'montant' => $request->montant,
            'description' => "Modification Dépense : ".$depense->typedepense?->type." | ancien montant: ".$ancien_montant." => nouveau montant: ".$request->montant,
            'caisse_id' => $request->caisse_id,
            'user_id' => Auth::user()->id,
            'resource_id' => $depense->id,
            'solde' => $caisse?->solde,
        ];
    
        Transaction::ajouter($data);

        return redirect()->route('depense.index')->with('success', 'Dépense modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        //²
    }

     /**
     * Archivage de la dépense
     */
    public function archiver($depense_id)
    {
        $depense = Depense::where('id', Crypt::decrypt($depense_id))->first();
        $depense->archive = true;
        $depense->update(); 
        
        return redirect()->back()->with('ok','Dépense archivée');

    }
    
    /**
     * Désarchivage de la dépense
     */
    public function desarchiver($depense_id)
    {
        $depense = Depense::where('id', Crypt::decrypt($depense_id))->first();
        $depense->archive = false;
        $depense->update();
        
        return redirect()->back()->with('ok','Dépense désarchivée');

    }
}
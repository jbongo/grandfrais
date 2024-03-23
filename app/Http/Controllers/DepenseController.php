<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Typedepense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typedepenses = Typedepense::where('archive', false)->get();
        return view('depense.index', compact('typedepenses'));
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
            $depense->details = $request->details;
            $depense->montant = $request->montant;
            $depense->date_depense = $request->date_depense;
            $depense->save();
    
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

        $depense->montant = $request->montant;
        $depense->date_depense = $request->date_depense;
        $depense->save();

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
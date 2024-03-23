<?php

namespace App\Http\Controllers;

use App\Models\Typedepense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TypedepenseController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $typedepenses = Typedepense::where('archive', false)->get();
        return view('parametres.typedepense.index', compact('typedepenses'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "type" => "required|unique:typedepenses"
        ]);
        
        Typedepense::create([
            "type" => $request->type
        ]);
        
        return redirect()->back()->with('ok','Nouveau type de dépense ajoutée');
     
    }

    /**
     * Display the specified resource.
     */
    public function show($typedepense_id)
    {
        $typedepense = Typedepense::where('id', Crypt::decrypt($typedepense_id))->first();
        
        return view('depenses.show', compact('typedepense'));
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $typedepense_id)
    {
        $typedepense = Typedepense::where('id', Crypt::decrypt($typedepense_id))->first();
        
        if($request->type != $typedepense->type){
            $request->validate([
                "type" => "required|unique:typedepenses"
            ]);
            
        }else{
            $request->validate([
                "type" => "required"
            ]);
            
        }
        
        
        $typedepense->type = $request->type;
        $typedepense->update();
        
        return redirect()->back()->with('ok','Type de type de dépense modifiée');
        
    }

    /**
     * Suppression du type de dépense
     */
    public function destroy($typedepense_id)
    {
        $typedepense = Typedepense::where('id', Crypt::decrypt($typedepense_id))->first();
        
        $typedepense->destroy();
        
        return "ok";
    }
    
     /**
     * Archivage du type de dépense
     */
    public function archive($typedepense_id)
    {
        $typedepense = Typedepense::where('id', Crypt::decrypt($typedepense_id))->first();
        $typedepense->archive = true;
        $typedepense->update(); 
        
        return redirect()->back()->with('ok','Type de dépense archivée');

    }
    
    /**
     * Désarchivage du type de dépense
     */
    public function unarchive($typedepense_id)
    {
        $typedepense = Typedepense::where('id', Crypt::decrypt($typedepense_id))->first();
        $typedepense->archive = false;
        $typedepense->update();
        
        return redirect()->back()->with('ok','Type de dépense désarchivée');

    }
    
    
    
  
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Typecontact;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\EntiteIndividu;
use App\Models\Prestation;
use Auth;
use Illuminate\Validation\Rule;



use Illuminate\Support\Facades\Crypt;


class ContactController extends Controller
{
    /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $contacts = Contact::where('archive', false)->get();
       


        return view('contact.index', compact('contacts'));
    }

    /**
     * Affiche la liste des contacts archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        
        $contactentites = Contact::where([["type","entite"], ['archive', true]])->get();
        $contactindividus = Contact::where([["type","individu"], ['archive', true]])->get();

        return view('contact.archives', compact('contactentites', 'contactindividus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
       $contacts = Contact::where('user_id', Auth::id())->get();
       $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();
       $typecontacts = Typecontact::where('archive', false)->get();
       return view('contact.add', compact('contactindividus','contacts','typecontacts'));
    }

    /**
     * Enregistrer les contacts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $returnContact = false)
    {
    
   
        $contact = Contact::create([
            
            "user_id" => Auth::user()->id,
            "type" => $request->type,
            "civilite" => $request->civilite,
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "entreprise" => $request->entreprise,
            "email" => $request->email,
            "indicatif_1" => $request->indicatif_1,
            "indicatif_2" => $request->indicatif_2,
            "telephone_1" => $request->telephone_1,
            "telephone_2" => $request->telephone_2,
            "ville" => $request->ville,
            "quartier" => $request->quartier,
            "notes" => $request->notes,

        ]);
        

        
        return redirect()->route('contact.show', Crypt::encrypt($contact->id))->with('ok', 'Contact ajouté');
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contact_id)
    {
            $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
            return view('contact.show', compact('contact'));
        
    }



    /**
     * Page de modification du contact
     *
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function edit($contact_id)
    {
    
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();     
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();
        $typecontacts = Typecontact::where('archive', false)->get();

        $typecontact = Typecontact::where('type', $contact->type)->first();

        return view('contact.edit', compact('contact','contactindividus','typecontacts','typecontact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();

        $request->validate([
            "type" => "required",
            "civilite" => "required",
            "nom" => "required",

        ]);

        
        $contact->type = $request->type;
        $contact->civilite = $request->civilite;
        $contact->nom = $request->nom;
        $contact->prenom = $request->prenom;
        $contact->entreprise = $request->entreprise;
        $contact->email = $request->email;
        $contact->indicatif_1 = $request->indicatif_1;
        $contact->indicatif_2 = $request->indicatif_2;
        $contact->telephone_1 = $request->telephone_1;
        $contact->telephone_2 = $request->telephone_2;
        $contact->ville = $request->ville;
        $contact->quartier = $request->quartier;
        $contact->notes = $request->notes;
        
        $contact->update();
        
        return redirect()->route('contact.show', Crypt::encrypt($contact->id))->with('ok', 'Contact modifié');
        

    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
     /**
     * Archiver un contact
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        
        $contact->archive = true;
        $contact->update();
        
        return "200";
    }

     /**
     * Restaurer un contact
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unarchive($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        
        $contact->archive = false;
        $contact->update();
        
        return "200";
    }
}
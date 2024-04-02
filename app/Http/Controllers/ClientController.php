<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Client;
use Illuminate\Http\Request;
use Auth;
use Crypt;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Typecontact;

class ClientController extends Controller
{
    /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.index' );
    }

    /**
     * Affiche la liste des contacts archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        return view('client.archives');
    }

    /**
     * Formulaire de création de forunisseur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(Auth::user()->role())
        $contacts = Contact::where('user_id', Auth::id())->get();
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();
        
        return view('client.add', compact('contactindividus','contacts'));
    }

   
}
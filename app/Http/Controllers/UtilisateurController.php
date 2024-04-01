<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Typecontact;
use App\Models\User;
use App\Models\Individu;
use App\Models\Role;
use Auth;
use Hash;
use Illuminate\Support\Facades\Crypt;


class UtilisateurController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();

        return view('utilisateur.index', compact('contactindividus'));
    }


    /**
     * Affiche la liste des utilisateurs archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        return view('utilisateur.archives');
    }
    
     /**
     *Page de création d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();     
        $roles = Role::where('archive', false)->get();
        $individus = Individu::where('archive', false)->get();
        return view('utilisateur.add', compact('contactindividus', 'roles', 'individus'));
    }
    
    /**
     *Page de modification d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        
        $user = User::where('id', Crypt::decrypt($user_id))->first();
     
        $roles = Role::where('archive', false)->get();
        $individus = Individu::where('archive', false)->get();
        $infosUser = $user?->infos();
        return view('utilisateur.edit', compact('user', 'roles', 'individus', 'infosUser'));
    }
    
    
    /**
    *   Ajouter un utilisateur
    */
    public function store(Request $request){

            $request->validate([
                'email' => 'required|email|unique:users',
            ]);

        

            $contact = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $request->type,
                "email" => $request->email,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "civilite" => $request->civilite, 
                "ville" => $request->ville,
                "quartier" => $request->quartier,
                "indicatif_1" => $request->indicatif_1,
                "telephone_1" => $request->telephone_1,
                "indicatif_2" => $request->indicatif_2,  
                "telephone_2" => $request->telephone_2,  
            ]);

        
        $user = new User();

        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->contact_id = $contact->id;
        $user->password = Hash::make($request->password);

        $user->save();

       return redirect('/utilisateurs')->with('ok', 'Utilisateur ajoute avec succes');
        
    }

    /*
    *   Modifier un utilisateur
    */
    public function update(Request $request, $user_id){
// hasunique
        $request->validate([
          "email" => 'required|email',
        ]);
        $user = User::where('id', Crypt::decrypt($user_id))->first();
      
        $contact = Contact::where('id', $user->contact_id)->first();

        $contact->email = $request->email;
        $contact->nom = $request->nom;
        $contact->prenom = $request->prenom;
        $contact->civilite = $request->civilite;
        $contact->ville = $request->ville;
        $contact->quartier = $request->quartier;
        $contact->indicatif_1 = $request->indicatif_1;
        $contact->telephone_1 = $request->telephone_1;
        $contact->indicatif_2 = $request->indicatif_2;
        $contact->telephone_2 = $request->telephone_2;

        $contact->update();
        

        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role;

        $user->update();
        
        return back()->with('ok', 'Utilisateur modifié');
    }

    /**
     * Archiver un user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($user_id)
    {
        $user = User::where('id', Crypt::decrypt($user_id))->first();
        
        $user->archive = true;
        $user->update();
        
        return "200";
    }

     /**
     * Restaurer un user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unarchive($user_id)
    {
        $user = User::where('id', Crypt::decrypt($user_id))->first();
        
        
        $user->archive = false;
        $user->update();
        
        return "200";
    }
}
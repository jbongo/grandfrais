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
        $typecontact = Typecontact::where('type', $request->type_contact)->first();

        if($request->contact_existant){

            $individu = Individu::where('id', $request->individu_id)->first();
            $contact = $individu->contact;
       

        }else{
            $contact = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $request->type_contact,
                "nature" => $request->nature,    
            ]);

            Individu::create([
                "email" => $request->email,
                "contact_id" => $contact->id,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "civilite" => $request->civilite, 
                "ville" => $request->ville,
                "quartier" => $request->quartier,
                "indicatif_fixe" => $request->indicatif_fixe,
                "telephone_fixe" => $request->telephone_fixe,
                "indicatif_mobile" => $request->indicatif_mobile,  
                "telephone_mobile" => $request->telephone_mobile,  
            ]);
            
            $contact->typecontacts()->attach($typecontact->id);

        }
        
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
      
  

        $user->update([
            'email' => $request->email,
        ]);

       
      

        $individu = Individu::where('contact_id', $user->contact_id)->first();

        
        $individu->email = $request->email;
        $individu->contact_id = $user->contact_id;
        $individu->nom = $request->nom;
        $individu->prenom = $request->prenom;
        $individu->civilite = $request->civilite;
        $individu->ville = $request->ville;
        $individu->quartier = $request->quartier;
        $individu->indicatif_fixe = $request->indicatif_fixe;
        $individu->telephone_fixe = $request->telephone_fixe;
        $individu->indicatif_mobile = $request->indicatif_mobile;
        $individu->telephone_mobile = $request->telephone_mobile;



        $individu->update();

        

        $user->email = $request->email;
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
<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Societe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class EditForm extends Component
{

    public $nom;
    public $prenom;
    public $email; 
    public $entreprise;
    public $quartier;
    public $ville;           
   
    public $indicatif_1;
    public $telephone_1;
    public $indicatif_2;
    public $telephone_2;
   
    public $type;
    public $civilite;   
    public $notes;
    
    public $typecontact;
    public $typecontacts;
    public $displaytypecontact;
    public $contact;
    
    
    public function mount(){


        $this->type = $this->contact->type;
        $this->civilite =  $this->contact->civilite;
        $this->nom =  $this->contact->nom;      
        $this->email =  $this->contact->email;      
        $this->prenom =  $this->contact->prenom;
       
        $this->entreprise =  $this->contact->entreprise;
        $this->email =  $this->contact->email;
      
        $this->ville = $this->contact->ville;
        $this->quartier = $this->contact->quartier;
      
   
        $this->telephone_1 =  $this->contact->telephone_1;
        $this->indicatif_1 =  $this->contact->indicatif_1;
        $this->telephone_2 =  $this->contact->telephone_2;
        $this->indicatif_2 =  $this->contact->indicatif_2;

      
        $this->notes =  $this->contact->notes;
        
    }
    
    public function rules()
    {

        
        return [
            'nom' => 'required|string',
            'type' => 'required|string',
          

        ];
    }
    
     public function submit()
    {

        $this->validate();
    }
    
    public function render()
    {
       
        return view('livewire.contact.edit-form');
    }
}
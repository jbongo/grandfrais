<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Societe;

use Illuminate\Database\Eloquent\Builder;

class AddForm extends Component
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
    
   
    public function rules()
    {
    
            return [           
                'nom' => 'required|string',
                'type' => 'required|string',
                'email' => 'email|unique:contacts',
            ];

     

    }

    public function submit()
    {

        $this->validate();
    }
    
    public function render()
    {   
        $this->ville = "Abidjan";
        return view('livewire.contact.add-form');
    }
}
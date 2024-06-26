<?php

namespace App\Http\Livewire\Produit;
use Livewire\WithFileUploads;

use Livewire\Component;

class EditForm extends Component
{
    use WithFileUploads;

    public $type;
    public $nature;
    public $nom;
    public $reference;
    public $description;
    public $images;
    public $categories;
    public $categories_id = [];
    
    public $fiche_technique;
    public $marque;
    public $marques;
    public $a_declinaison;
    public $prix_vente_ttc;
    public $prix_achat_ttc;

    
    public $quantite;
    public $quantite_min_vente;
    public $gerer_stock;
    public $seuil_alerte_stock;
    public $produit;
    public $caracteristiques;
    public $unite_mesure;
        
        
    public function mount(){
    
        $this->type = $this->produit->type;
        $this->nature = $this->produit->nature;
        $this->reference = $this->produit->reference;
        $this->nom = $this->produit->nom;
        $this->description = $this->produit->description;
        $this->images = $this->produit->images;
        $this->categories_id = $this->produit->categorieproduitsId();
        
        $this->fiche_technique = $this->produit->fiche_technique;
        $this->a_declinaison = $this->produit->a_declinaison;
        $this->marque = $this->produit->marque_id;
        $this->prix_vente_ttc = $this->produit->prix_vente_ttc;
        $this->prix_achat_ttc = $this->produit->prix_achat_ttc;
        
        $this->quantite = $this->produit->quantite_stock ;
        $this->unite_mesure = $this->produit->unite_mesure_stock ;
        

        $this->gerer_stock = $this->produit->gerer_stock;
        $this->seuil_alerte_stock = $this->produit->seuil_alerte_stock ;
    
    }
    
    public function render()
    {
        return view('livewire.produit.edit-form');
    }
    
    
    /**
    * Validation des champs
    */
    public function rules()
    {
    
       

        $require = [
            'type' => 'required',
            'prix_vente_ttc' => 'required',                
        ];
        
       
        if($this->nom == $this->produit->nom){
            $require = array_merge($require,['nom' => 'required|string']);
        }
        else{
            $require = array_merge($require,['nom' => 'required|string|unique:produits']);
        }
        
        
        // if($this->reference == $this->produit->reference){
            
        //     $require = array_merge($require,['reference' => 'required|string']);           
           
        // }
        // else{

        //     $require = array_merge($require,['reference' => 'required|string|unique:produits']);
        
        // }
        
        
// dd($require);

        return $require;
    }

    public function submit()
    {

        $this->validate();
    }
}
    
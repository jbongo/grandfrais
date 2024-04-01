<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;
    protected $guarded =[];
    
   
    /**
     * Retourne les infos du contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infos()
    {
        if($this->nature == "Personne physique"){
            return $this->individu;
        
        }else{
            return $this->entite;
        }
    }
    
    
    /**
     * Retourne l'individu lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    
    /**
     * Retourne l'individu lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fournisseur()
    {
        return $this->hasOne(Fournisseur::class);
    }

    /*
    * Retourne l'utilisateur lié au contact
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defendeur extends Model
{
	// determiner les champs a inserer
    protected $fillable=['nom_defendeur','adresse_defendeur','nbr_avocat'];
    // annuller l'insertion de la date

    public $timestamps=false;
    // definir la cle primaire
        protected $primaryKey='id_defendeur';

    // definition de la relation un<->plusieur 
    public function avocats(){
        return $this->belongsToMany(Avocat::class);
    }

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avocat extends Model
{
	// determiner les champs a inserer 
    protected $fillable=['nom_avocat','adresse_avocat'];
    // definir le cle primaire
        protected $primaryKey='id_avocat';
 // annuller l'insertion de la date
    public $timestamps=false;
    public function procureurs(){
        return $this->belongsToMany(Procureur::class);
    }
    public function defendeurs(){
        return $this->belongsToMany(Defendeur::class);
    }
}
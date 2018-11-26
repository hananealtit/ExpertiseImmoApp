<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arrivant extends Model
{
	// determiner les champs a inserer 
    protected $fillable=['nom_arrivant','pourcentage'];
    // annuller l'insertion de la date
    public $timestamps=false;
    // definir le cle primaire
    protected $primaryKey='id_arrivant';
}

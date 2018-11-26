<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defendeurs_immobiliers extends Model
{
     // annuller l'insertion de la date
    public $timestamps=false;
    // definir la cle primaire
    protected $primaryKey='id_defendeur';
    // determiner les champs a inserer 

    protected $fillable=['id_defendeur','id_immobilier','pourcentage'];
}

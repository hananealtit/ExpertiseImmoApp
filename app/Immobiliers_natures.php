<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Immobiliers_natures extends Model
{
// determiner les champs a inserer 

    protected $fillable=['immobiliers_num_immobiliers','natures_id_natures','immobiliers_jugements_num_jugements','immobiliers_jugements_dossiers_num_dossiers','immobiliers_jugements_tribunals_id_tribunals'];
   // definir la cle primaire
    protected $primaryKey='immobiliers_num_immobilier';
    // annuller l'insertion de la date

    public $timestamps=false;
}
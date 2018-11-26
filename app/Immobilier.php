<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Immobilier extends Model
{
// determiner les champs a inserer 
    protected $fillable=['num_immobilier','adresse_immobilier','designation_immobilier','jugements_num_jugement','jugements_dossiers_num_dossier','jugements_tribunals_id_tribunal'];
   // definir la cle primaire
    protected $primaryKey='jugements_num_jugement';
   // annuller l'insertion de la date

    public $timestamps=false;

    public function jugement(){
       return $this->belongsTo(Jugement::class);
   }

   public function natures(){
       return $this->belongsToMany(Nature::class);
   }
}
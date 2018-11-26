<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    // determiner les champs a inserer 

    protected $fillable=['num_dossier','etat_dossier','date_depot_dossier','personnels_id_personnel'];
    // definir la cle primaire
    protected $primaryKey='num_dossier';

     // annuller l'insertion de la date

    public $timestamps=false;

    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }

    public function jugement(){
        return $this->belongsTo(Jugement::class);
    }
    // retourne le numero de dossier
    public function getNumDossierAttribute($value)
    {
        return $value;
    }
}
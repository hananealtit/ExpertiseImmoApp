<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
	// determiner les champs a inserer 
    protected $fillable=['designation_batiment','surface','img_batiment','fermer','louer','prix_location','designation_etage','immobiliers_num_immobilier'];
    // annuller l'insertion de la date
    public $timestamps=false;
    // definir la cle primaire
    protected $primaryKey='id_batiment';
}

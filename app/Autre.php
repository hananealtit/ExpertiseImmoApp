<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autre extends Model
{
	// determiner les champs a inserer 
    protected $fillable=['description_autre'];
 // annuller l'insertion de la date
    public $timestamps=false;
    // definir le cle primaire
    protected $primaryKey='id_autre';
    public function jugements(){
        return $this->belongsToMany(Jugement::class);
    }
}

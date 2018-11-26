<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defendeurs_avocats extends Model
{
	// annuller l'insertion de la date
    public $timestamps=false;
    // definir la cle primaire
        protected $primaryKey='defendeurs_id_defendeur';

}

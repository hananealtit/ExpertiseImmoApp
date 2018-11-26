<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procureur extends Model
{
    protected $fillable=['nom_procureur','adresse_procureur','nbr_avocat'];
    public $timestamps=false;
        protected $primaryKey='id_procureur';

    public function avocats(){
        return $this->belongsToMany(Avocat::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procureurs_immobiliers extends Model
{
    public $timestamps=false;
    protected $primaryKey='id_procureur';
    protected $fillable=['id_procureur','id_immobilier','pourcentage'];
}

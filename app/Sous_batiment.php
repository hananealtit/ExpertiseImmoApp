<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sous_batiment extends Model
{
    protected $fillable=['designation','img','surface','louer','prix_location','id_batiment'];
    public $timestamps=false;
    protected $primaryKey='id_sous_batiment';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugements_defendeurs extends Model
{
    public $timestamps=false;
    public $table="jugements_defendeurs";
    protected $primaryKey='jugements_num_jugement';
}
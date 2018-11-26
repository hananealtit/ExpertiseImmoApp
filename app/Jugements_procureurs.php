<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugements_procureurs extends Model
{
    public $timestamps=false;
    public $table="jugements_procureurs";
    protected $primaryKey='jugements_num_jugement';
}
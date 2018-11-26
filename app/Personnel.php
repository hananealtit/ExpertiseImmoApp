<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    public $timestamps=false;

    public $primaryKey="id_personnel";

    public function dossiers(){
        return $this->hasMany(Dossier::class);
    }
}

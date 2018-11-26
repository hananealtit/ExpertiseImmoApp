<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nature extends Model
{
    public $timestamps=false;

    public function immobiliers(){
        return $this->belongsToMany(Immobilier::class);
    }
}
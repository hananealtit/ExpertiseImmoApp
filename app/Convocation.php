<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{

// annuller l'insertion de la date
    public  $timestamps=false;
    // definir le cle primaire
    protected $primaryKey='id_convocation';

// retoune la date de convocation
    public function getDateConvocationAttribute($value){

            return $value;

    }
    // insertion de la date de convocation
    public function setDateConvocationAttribute($date){
        $this->attributes['date_convocation']=Carbon::createFromFormat('d/m/Y',$date);
    }
}
<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Jugement extends Model
{

// annuller l'insertion de la date

    public $timestamps=false;
    // definir la cle primaire
    protected $primaryKey = 'num_jugement';
    // determiner les champs a inserer 

    protected $fillable=['num_jugement','date_jugement','nom_juge','date_arrivee','duree_jugement','prix_expertise','tribunals_id_tribunal',''];
    protected $casts=['date_jugement','date_arrivee'];
    /**
     * definir la relation 1..*
     **/
    public function immobiliers(){
        return $this->hasMany(Immobilier::class);
    }
    /**
     * definir la relation 
     **/
    public function dossiers(){
        return $this->hasMany(Dossier::class);
    }
  
    public function autres(){
        return $this->belongsToMany(Autre::class);
    }
   // inserer la date de jugement
    public function setDateJugementAttribute($value){
        $this->attributes['date_jugement']=Carbon::createFromFormat('d/m/Y',$value);
    }

   // inserer la date d'arriver

    public function setDateArriveeAttribute($date){
        if($date==null){
            $this->attributes['date_arrivee']=null;
        }else{
            $this->attributes['date_arrivee']=Carbon::createFromFormat('d/m/Y',$date);

        }
    }

    public function setDeclarationAttribute($date){
        if($date==null){
            $this->attributes['declaration']=null;
        }else{
            $this->attributes['declaration']=Carbon::createFromFormat('d/m/Y',$date);

        }
    }
    public function setDateRepanseAttribute($date){
        if($date==null){
            $this->attributes['date_repanse']=null;
        }else{
            $this->attributes['date_repanse']=Carbon::createFromFormat('d/m/Y',$date);

        }
    }
    public function setDateDepotAttribute($date){
        if($date==null){
            $this->attributes['date_depot']=null;
        }else{
            $this->attributes['date_depot']=Carbon::createFromFormat('d/m/Y',$date);

        }
    }
    // retourne le numero de jugement

    public function getNumJugementAttribute($value)
    {
        return $value;
    }
    // retourne la date d'arriver

    public function getDateArriveeAttribute($value){
        if($value==null){
            return $value;
        }else {
            return date('d/m/Y', strtotime($value));
        }
    }
    public function getDateDepotAttribute($value){
        if($value==null){
            return $value;
        }else {
            return date('d/m/Y', strtotime($value));
        }
    }
    public function getDeclarationAttribute($value){
        if($value==null){
            return $value;
        }else {
            return date('d/m/Y', strtotime($value));
        }

    }
    public function getDateRepanseAttribute($value){
        if($value==null){
            return $value;
        }else {
            return date('d/m/Y', strtotime($value));
        }
    }
}
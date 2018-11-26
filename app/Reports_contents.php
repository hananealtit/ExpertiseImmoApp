<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports_contents extends Model
{
    protected $fillable=['titre','contents','num_dossier'];
    public $timestamps=false;
    protected $primaryKey='id';


}

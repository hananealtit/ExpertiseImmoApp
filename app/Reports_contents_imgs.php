<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports_contents_imgs extends Model
{
    protected $fillable=['name','id_report_content'];
    public $timestamps=false;
    protected $primaryKey='id';
    

}

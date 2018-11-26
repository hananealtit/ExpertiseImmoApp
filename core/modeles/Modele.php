<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21/05/2017
 * Time: 16:16
 */

namespace core\modeles;
use \Config;

class modele
{
    private $bd='id1810075_sivexo';
    protected $pdo;
   public function __construct()
   {
       \Config::$default['dbname']=$this->bd;
       $this->pdo=\App::getInstance()->getdb();
   }
   private function getTable()
   {
       $table=explode('\\',get_class($this));
       $table=lcfirst(end($table));
       return $table;
   }
   public function add($data)
   {
       $attr=[];
       $val=[];
       foreach ($data as $key=>$value){
           $attr[]="$key=?";
           $val[]=$value;
       }
       $attr=implode(', ',$attr);
       $this->pdo->prepare("insert into {$this->getTable()} set $attr",$val);
   }
   public function getAll()
   {
       return $this->pdo->query("select * from {$this->getTable()}");
   }
   public function search($a,$one=false)
   {

       $attr=[];
       $value=[];
       $sql="select * from {$this->getTable()}";
       if(isset($a['fields'])){
          $sql="select {$a['fields']} from {$this->getTable()}";
       }
       if(isset($a['cond'])){
           $cond=$a['cond'];

           foreach ($cond as $key=>$val){
               if(strpos($val,'/')===0){
                   $pa=explode('/',$val);
                   $attr[]="$key $pa[1]";
               }else {
                   $attr[] = "$key=?";
                   $value[] = $val;
               }
           }
           $params=implode(' and ',$attr);
           $sql.=" where $params";
       }
       if(isset($a['advence'])){
           $sql.= $a['advence'];
       }
       return $this->pdo->prepare($sql,$value,$one);
   }
   public function getLastInsertId()
   {
       return $this->pdo->getLastinsertid();
   }
   public function update($data,$conds)
   {
       $attr=[];
       $val=[];
       $key=[];
       $value=[];
       $cond=$conds['cond'];
       foreach ($data as $k=>$v){
           $attr[]="$k=?";
           $val[]=$v;
       }
       foreach ($cond as $k=>$v){
           $key[]="$k=?";
           $value[]=$v;
           $val[]=$v;
       }
       $attr=implode(', ',$attr);
       $param=implode(' and ',$key);
       $sql="update {$this->getTable()} set {$attr} where {$param}";
       var_dump($sql,$val);
       $this->pdo->prepare("update {$this->getTable()} set {$attr} where {$param}",$val);
   }
   public function delete($data){
       $attr=[];
       $val=[];
       if(isset($data['cond'])){
           $cond=$data['cond'];
           foreach ($cond as $k=>$v){
               $attr[]="$k=?";
               $val[]=$v;
           }
           $attr=implode(' and ',$attr);
       }
       $this->pdo->prepare("delete from {$this->getTable()} where {$attr}",$val);
   }
}
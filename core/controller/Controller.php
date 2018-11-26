<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/05/2017
 * Time: 15:17
 */

namespace core\controller;


class Controller
{
    protected $request;
    protected $a=[];
    public function __construct($request)
    {
        $this->request=$request;
    }

    public function render($view)
    {
        extract($this->a);
       $param=explode('\\',get_class($this));
       $page=end($param);
       $page=str_replace('Controller','',$page);
        ob_start();
       if(strpos($view,'/')===0){
           require APP.'view'.DS.'errors'.DS.'404.php';
       }else if($view!='confirmation'){
           require(APP.'view'.DS.$page.DS.$view.'.php');
       }
       $content=ob_get_clean();
       require_once APP.'view'.DS.'template'.DS.'default.php';
    }


    public function set($key,$value=false){
        if(is_array($key) || is_object($key)){
            $this->a=$key;
        }
        else{
            $this->a[$key]=$value;
        }
    }
    public function e404($message)
    {
        header("HTTP/1.0 404 Not Found");
        $this->set("error",$message);
        $this->render("/404");
    }
    public function load($modele)
    {
        if(!isset($this->$modele))
        {
            $this->$modele=\App::getInstance()->loadModel($modele);
        }
    }
}
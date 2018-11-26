<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/05/2017
 * Time: 12:14
 */

namespace core;


class Dispatcher
{
    private $request;
    private $controller;
     public function __construct()
     {
         $this->request=new Request();
         Router::parse($this->request->url,$this->request);
         $this->controller=$this->loadController();
         $action=$this->request->action;
//         $this->controller->$action;
          if(!in_array($action,get_class_methods($this->controller))){
              $this->error("le controller:{$this->request->controller} n'a pas de methods {$action}");
              die();
          }
          
      call_user_func_array(array($this->controller,$action),[$this->request->param]);
         $this->controller->render($action);
     }
     public function loadController()
     {
         $nameController='\\app\\controller\\'.$this->request->controller.'Controller';
         return new $nameController($this->request);
     }
     public function error($message){
         $this->controller->e404($message);
     }
}
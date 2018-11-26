<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21/05/2017
 * Time: 23:22
 */

namespace core\session;

class Session {

    public function __construct()
    {
        session_start();
    }


    public function setFlach($type,$message)
    {
        $_SESSION['flach'][$type]=$message;
    }
    public function getFlach()
    {
        return $_SESSION['flach'];
    }
    public function hasFlach()
    {
        return isset($_SESSION['flach']);
    }
    public function delete($key){
        unset($_SESSION[$key]);
    }
    public function setKey($key,$value)
    {
        $_SESSION[$key]=$value;
    }
    public function getKey($key)
    {
        return isset($_SESSION[$key])?$_SESSION[$key]:false;
    }
}
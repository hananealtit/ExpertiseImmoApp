<?php
namespace core;

class Autoloader{

    public static function autoloading(){
        spl_autoload_register([__CLASS__,'autoload']);
    }

    static function autoload($classname){
        if(strpos($classname,__NAMESPACE__)===0){
            $class=str_replace(__NAMESPACE__.'\\','',$classname);
            $class=str_replace('\\','/',$class);
//            echo'<pre>';
//            var_dump(__DIR__.DS.$class);
//            echo '</pre>';
            require(__DIR__.DS.$class.'.php');
        }



    }
}
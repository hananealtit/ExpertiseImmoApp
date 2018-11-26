<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/05/2017
 * Time: 14:22
 */

namespace core;


class Request
{
    public $url;
    public $controller;
    public $action;
    public $param;
    public function __construct()
    {
        $this->url=$_SERVER['REQUEST_URI'];
    }
}
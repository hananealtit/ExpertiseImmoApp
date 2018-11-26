<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/05/2017
 * Time: 14:42
 */

namespace core;


class Router
{
    static function parse($url, $request)
    {
        $url = trim($url, '/');
        $param = explode('/', $url);
        $request->controller = (isset($param[0]) && !empty($param[0])) ? $param[0] : 'index';
        $request->action = isset($param[1]) ? $param[1] : 'index';
        $request->param = array_slice($param, 2);
//        var_dump($request->param);
    }
}
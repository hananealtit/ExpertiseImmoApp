<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21/05/2017
 * Time: 15:31
 */

namespace core\database;
use \PDO;

class MysqlDatabase
{

    private $db;
    private $config;


    public function getDb()
    {
        $this->config=\Config::$default;
        try {
            if($this->db==null) {
                $db = new PDO("mysql:host={$this->config['host']};dbname=id1810075_sivexo;charset:UTF-8", $this->config['login'], $this->config['pass']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->db = $db;
            }
                return $this->db;
        }
        catch(PDOException $e)
        {
            echo 'erreur de connection';
        }
    }

    public function query($sql,$one=false)
    {
        $res=$this->getDb()->prepare($sql);
        $res->execute();
        if($one)
        {
            return $res->fetch();
        }
        else{
            return $res->fetchAll();
        }
    }
    public function prepare($sql,$param,$one=false)
    {
        $res=$this->getDb()->prepare($sql);
        $res->execute($param);
        if(strpos($sql,'insert')===0 ||strpos($sql,'update')===0 || strpos($sql,'delete')===0)
        {
            return $res;
        }
        if($one)
        {
            return $res->fetch();
        }
        else{
            return $res->fetchAll();
        }
    }

    public function getLastinsertid()
    {
        return $this->getDb()->lastInsertId();
    }

}

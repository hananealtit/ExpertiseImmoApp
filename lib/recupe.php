<?php
require 'Config.php';
require '../app/App.php';
define('URL',dirname($_SERVER['SCRIPT_NAME']).'/'.$_SERVER['HTTP_HOST'].'/');
require '../core/database/MysqlDatabase.php';
$db=new \core\database\MysqlDatabase();

//remplissage du select location

if(isset($_POST['option'])){
    $res=$db->query('select * from location');
    if($_POST['option']==='TFZ'){
        foreach ($res as $bat)
        {
            if(preg_match('/(TFZ)/i',$bat->Batiment)){
                echo "<option value='$bat->Batiment'>$bat->Batiment</option>";
            }
        }

    }
    if($_POST['option']==='TOS'){
        foreach ($res as $bat)
        {
            if(preg_match('/(Batiment)/i',$bat->Batiment)){
                echo "<option value='$bat->Batiment'>$bat->Batiment</option>";
            }
        }
    }
}
//l'inscription et la connexion avec gmail

if(isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['email'])){
    $user=$db->prepare('select * from users where email=?',[$_POST['email']],true);
    if($user){
        var_dump($user);
        $_SESSION['auth']=$user;
        $alphabet='0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $remember_token=substr(str_shuffle(str_repeat($alphabet,255)),0,255);
        setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id) . 'bagira', (time() + 60 * 60 * 24 * 7),'/');
    }else{
        $donnee=explode(' ',$_POST['nom']);
        $nom=$donnee[0];
        $prenom=$donnee[1];
        $db->prepare('insert into users set nom=?,prenom=?,email=?,password=?',[$nom,$prenom,$_POST['email'],$_POST['id']]);
       }


}
//verification de l'existance des site dans la base de donnee
//
if(isset($_POST['nsite'])){
    $res=$db->prepare('select * from site WHERE site=?',[$_POST['nsite']],true);
    if($res){
        echo $res->site;
    }

}


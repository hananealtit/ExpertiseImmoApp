<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 03/05/2017
 * Time: 14:58
 */

class Functions {

    static function debug()
    {
        $session=\App::getInstance()->getSession();
        if($session->hasFlach())
        {
            $flach=$session->getFlach();
            foreach($flach as $type=>$message)
            {
                ?>
                <div class="alert alert-<?=$type?>">
                    <?php
                    if($type=='danger')
                    {
                        foreach($message as $errors)
                        {
                            echo "<ul><li>$errors</li></ul>";
                        }
                    }
                    if($type=='success' || $type=='info')
                    {
                        echo($message);
                    }
                    ?>
                </div>
                <?php
            }

        }
        $session->delete('flach');
    }
    static function str_random($lenght)
    {
        $alphabet='0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        return substr(str_shuffle(str_repeat($alphabet,$lenght)),0,$lenght);


    }
    static function isLoged()
    {
        if(!\App::getInstance()->getSession()->getKey('auth'))
        {
            header('location:'.URL.'users/login');
            exit();
        }
        else{
          $u=\App::getInstance()->getSession()->getKey('auth');
          return $u->role;
        }
    }
    static function loged_only()
    {
        if(!\App::getInstance()->getSession()->getKey('auth')) {
            Session::getInstance()->setFlach('info', "attention vous n'avez pas le droit d'accedez a cette page");
            header('location:'.URL.'users/login');
            exit();
        }
    }

   

    /**
     *
     */
    static function setcookies_users()
    {
        $remember_token = \Functions::str_random(255);
        if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
            $token_remember = $_COOKIE['remember'];
            $part = explode('==', $token_remember);
            $users = \App::getInstance()->getdb()->prepare('select * from users where cin=? ', [$part[0]], true);
            if ($users) {
                echo 'ok';
                $content_cookie = $users->cin.'=='.$users->remember_token.sha1($users->cin).'bagira';
                if ($content_cookie == $token_remember) {
                    \App::getInstance()->getSession()->setKey('auth',$users);
                    setcookie('remember', $users->cin .'=='. $remember_token . sha1($users->cin) . 'bagira', time() + 60 * 60 * 24 * 7,'/');
                    header('location:'.URL.'intervention/interventionRegister');
                   exit();
                }
            }
            else{
                setcookie('remember',null,-1);
            }

        }
    }
    static function validator()
    {
        $errors=[];
        if(isset($_POST) && !empty($_POST)){
            if(empty($_POST['demandeur']) && !preg_match('/^[a-zA-Z]+$/',$_POST['demandeur'])){
                $errors['demandeur']="Veuillez donner un nom correct";
            }
            if(empty($_POST['site']))
            {
                $errors['site']="Veuillez entrer un site";
            }
            if(empty($_POST['description']))
            {
                $errors['description']="Veuillez entrer une description";
            }
            if(empty($_POST['choix'])) {
                $errors['choix']="Veuillez selectionner un etat";
            }
            if(!empty($errors)){
                Session::getInstance()->setFlach('danger',$errors);
                return false;
            }
            else{
                return true;
            }
        }
    }
}

?>
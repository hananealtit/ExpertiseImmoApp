<?php
require 'Config.php';
require '../app/App.php';
define('URL',dirname($_SERVER['SCRIPT_NAME']).'/'.$_SERVER['HTTP_HOST'].'/');
require '../core/database/MysqlDatabase.php';
$db=new \core\database\MysqlDatabase();

if(isset($_POST['nsite']) && !empty($_POST['nsite']) ){
    $tmp=$_FILES['image']['tmp_name'];
    $name=$_FILES['image']['name'];
    move_uploaded_file($tmp,'../public/img/'.$name);
    $db->prepare('insert into site set site=?,logo=?',[$_POST['nsite'],$name]);
    $lastId=$db->getLastinsertid();
    $row=$db->prepare('select * from site WHERE id=?',[$lastId],true);
    $url=explode('lib',URL);
    $url=end($url);
    $url=str_replace('/','//',$url);
    ?>
   <tr>
                <td><?=$row->site?></td>
                <td><img src="<?=$url?>/public/img/<?=$row->logo?>" alt="" width="100" height="100"></td>
                <td><a href='<?=$url?>/admin/deleteSite/<?=$row->id?>' class='btn btn-danger' id='myBtn'><span class='glyphicon glyphicon-remove'></span></a>&nbsp;&nbsp;&nbsp;<a href="" class="btn btn-primary" id="updat_i"><span class="glyphicon glyphicon-pencil"></span>  Modifier</a></td>
                
   </tr>
<?php
}
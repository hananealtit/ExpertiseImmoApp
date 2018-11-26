<?php
require "init.php";

$table= $_POST["table"];
$fieldTable= $_POST["fieldTable"];
$id= $_POST["id"];
$response = array();

$sqlUpdate ="Update ".$table." set present = '1' WHERE ".$fieldTable." = '".$id."'";

$res=$con->prepare($sqlUpdate);
    $res->execute();


    $code = "success_update";

    $message =  $id." ".$table." ".$fieldTable ;
    //$message = " تم التحديـث بنجـاح ";

  array_push($response,array("code"=>$code,"message"=>$message));
   echo json_encode($response);


?>
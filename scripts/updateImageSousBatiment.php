<?php
require "init.php";
$img= $_POST["img"];
$refSousBatiment= $_POST["refSousBatiment"];
$response = array();


    $sqlUpdate = "UPDATE sous_batiments SET img ='".$img."' WHERE ref_sous_batiment = '".$refSousBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم تحـديث الـصـورة بنـجاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
<?php
require "init.php";
$designation= $_POST["designation"];
$fermer= $_POST["fermer"];
$louer = $_POST["louer"];
$surface = $_POST["surface"];
$refSousBatiment= $_POST["refSousBatiment"];
$response = array();

    $sqlUpdate = "UPDATE sous_batiments SET designation ='".$designation."' , fermer ='".$fermer."', louer ='".$louer."', surface ='".$surface."' WHERE ref_sous_batiment = '".$refSousBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
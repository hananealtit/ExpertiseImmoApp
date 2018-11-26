<?php
require "init.php";
$refSousBatiment= $_POST["refSousBatiment"];
$designation = $_POST["designation"];
$surfaceE = $_POST["surfaceE"];
$response = array();

    $sqlUpdate = "UPDATE sous_batiments SET designation = '".$designation."',description = NULL, prix_location = NULL, fermer ='1', louer = 0, surface = '".$surfaceE."' WHERE ref_sous_batiment = '".$refSousBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
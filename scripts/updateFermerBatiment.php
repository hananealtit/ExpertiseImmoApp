<?php
require "init.php";
$refBatiment= $_POST["refBatiment"];
$surfaceE= $_POST["surfaceE"];
$response = array();

    $sqlUpdate = "UPDATE batiments SET surface= '".$surfaceE."',fermer ='1', louer = 0, prix_location = NULL, description= NULL WHERE ref_batiment = '".$refBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
<?php
require "init.php";
$PriceLocation= $_POST["PriceLocation"];
$description= $_POST["description"];
$refSousBatiment= $_POST["refSousBatiment"];
$surfaceE= $_POST["surfaceE"];
$response = array();

    $sqlUpdate = "UPDATE sous_batiments SET surface= '".$surfaceE."',img = NULL ,fermer = 0, louer ='1', prix_location ='".$PriceLocation."', description='".$description."' WHERE ref_sous_batiment = '".$refSousBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
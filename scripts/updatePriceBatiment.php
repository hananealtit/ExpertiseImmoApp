<?php
require "init.php";
$PriceLocation= $_POST["PriceLocation"];
$description= $_POST["description"];
$refBatiment= $_POST["refBatiment"];
$surfaceE= $_POST["surfaceE"];
$response = array();

    $sqlUpdate = "UPDATE batiments SET surface= '".$surfaceE."',img_batiment= NULL ,fermer = 0, louer ='1', prix_location ='".$PriceLocation."', description='".$description."' WHERE ref_batiment = '".$refBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
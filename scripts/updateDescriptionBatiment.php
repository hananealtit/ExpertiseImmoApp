<?php
require "init.php";
$description= $_POST["description"];
$refBatiment= $_POST["refBatiment"];
$response = array();

    $sqlUpdate = "UPDATE batiments SET description ='".$description."' WHERE ref_batiment = '".$refBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم تحديـث الوصـف بنـجاح ";
   
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
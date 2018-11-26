<?php
require "init.php";

$RefBatiment = $_POST["refBatiment"];

    $sqlDelete = "DELETE FROM sous_batiments WHERE ref_batiment='".$RefBatiment."'";
    $res=$con->prepare($sqlDelete);
    $res->execute();

    $sqlDlt = "DELETE FROM batiments WHERE ref_batiment='".$RefBatiment."'";
    $res=$con->prepare($sqlDlt);
    $res->execute();

    $response = array();
    $code = "success_delete";
    $message = " تم حذف ".$RefBatiment;
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
   
 ?>
<?php
require "init.php";

$RefSousBatiment = $_POST["refSousBatiment"];

    $sqlDelete = "DELETE FROM sous_batiments WHERE ref_sous_batiment='".$RefSousBatiment."'";

    $res=$con->prepare($sqlDelete);
    $res->execute();
    $response = array();
    $code = "success_delete";
    $message = " تم حذف ".$RefSousBatiment;
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
   
 ?>
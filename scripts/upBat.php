<?php
require "init.php";

$fermer= $_POST["fermer"];
$louer = $_POST["louer"];
$surface = $_POST["surface"];
$prixLocation= $_POST["prixLocation"];
$description = $_POST["description"];
$refBatiment= $_POST["refBatiment"];


$response = array();

    $sqlUpdate = "UPDATE batiments SET batiments.fermer ='".$fermer."', batiments.louer ='".$louer."', batiments.prix_location ='".$prixLocation."', batiments.description ='".$description."' ,batiments.surface ='".$surface."' WHERE batiments.ref_batiment = '".$refBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
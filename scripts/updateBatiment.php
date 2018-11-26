<?php
require "init.php";
$fermer= $_POST["fermer"];
$louer = $_POST["louer"];
$surface = $_POST["surface"];
$refBatiment= $_POST["refBatiment"];
$response = array();

// Mettre à jour les champs nb_etage & sous_sol pour la table immobiliers
    $sqlUpdate = "UPDATE batiments SET prix_location = NULL,fermer ='".$fermer."', louer ='".$louer."', surface ='".$surface."' WHERE ref_batiment = '".$refBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم التحديـث بنجـاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
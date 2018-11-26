<?php
require "init.php";
$description= $_POST["description"];
$refSousBatiment= $_POST["refSousBatiment"];
$response = array();

// Mettre à jour les champs nb_etage & sous_sol pour la table immobiliers
    $sqlUpdate = "UPDATE sous_batiments SET description ='".$description."' WHERE ref_sous_batiment = '".$refSousBatiment."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";

    $message = " تم تحديـث الوصـف بنـجاح ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
 ?>
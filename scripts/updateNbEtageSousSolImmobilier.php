<?php
require "init.php";
$nbEtage= $_POST["nbEtage"];
$SousSol = $_POST["SousSol"];
$numImmobilier = $_POST["numImmobilier"];
$designation= $_POST["designation"];
$response = array();

// Mettre à jour les champs nb_etage & sous_sol pour la table immobiliers
    $sqlUpdate = "UPDATE immobiliers SET nb_etage = '".$nbEtage."', sous_sol ='".$SousSol."' WHERE num_immobilier = '".$numImmobilier."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";
    if($SousSol == 1){
    $message =$designation."  تحـتوي على طابق تحت ارضـي و ".$nbEtage." طـوابق ";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
        
    }else {
           $message =$designation."  تحـتوي على ".$nbEtage." طـوابق ";  
           array_push($response,array("code"=>$code,"message"=>$message));
           echo json_encode($response);
        
    }


 ?>
<?php
require "init.php";
$numJugement = $_POST["numJugement"];
$numDossier = $_POST["numDossier"];
$fermer = $_POST["fermer"];
$louer= $_POST["louer"];
$numImmobilier = $_POST["numImmobilier"];
$designationNature = $_POST["designationNature"];

// Mettre à jour les champs fermer & louer pour la table immobiliers
$sqlUpdate = "UPDATE immobiliers SET immobiliers.fermer = '".$fermer."', immobiliers.louer = '".$louer."' WHERE immobiliers.num_immobilier = '".$numImmobilier."'";

$res=$con->prepare($sqlUpdate);
$res->execute();

// faire select : si l'immobilier a déjà une nature on fait update sinon insert
$sql = "select * from immobiliers_natures where immobiliers_num_immobilier like '".$numImmobilier."'";

$res=$con->prepare($sql);
$res->execute();
$immobilierNature = $res->fetch();
$response = array();

if(!empty($immobilierNature)) {
    // num immobilier déja existe dans la table immobilier nature
    $sqlUpdate ="UPDATE immobiliers_natures SET natures_id_nature=(SELECT id_nature FROM natures WHERE designation_nature ='".$designationNature."') WHERE immobiliers_natures.immobiliers_num_immobilier='".$numImmobilier."'";
     
    $res=$con->prepare($sqlUpdate);
    $res->execute();
    
    $code = "success_update";
    $message = "تم تحديث العـقـار ك".$designationNature;
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
} else {
   
   // num immobilier n'existe pas dans la table immobilier nature donc on va l'insérer
    $sqlInsert = "INSERT INTO immobiliers_natures (immobiliers_num_immobilier,natures_id_nature,immobiliers_jugements_num_jugement, immobiliers_jugements_dossiers_num_dossier) VALUES ((SELECT num_immobilier FROM immobiliers WHERE num_immobilier='".$numImmobilier."'),(SELECT id_nature FROM natures WHERE designation_nature ='".$designationNature."'),(SELECT jugements_num_jugement from immobiliers WHERE num_immobilier = '".$numImmobilier."'),(SELECT jugements_dossiers_num_dossier FROM immobiliers WHERE num_immobilier= '".$numImmobilier."'))";

    $res=$con->prepare($sqlInsert);
    $res->execute();
    
    $code = "success_insert";
    $message = "تم اضافة المـعـلومـات بنـجـاح";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
    }
   
 ?>
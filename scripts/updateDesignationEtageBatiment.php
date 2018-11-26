<?php
require "init.php";
$numImmobilier = $_POST["numImmobilier"];
$designationBatiment = $_POST["designationBatiment"];
$designationEtage = $_POST["designationEtage"];
$RefBatiment = $_POST["RefBatiment"];

  
    $sqlInsert = "INSERT INTO batiments (designation_batiment,designation_etage,immobiliers_num_immobilier, ref_batiment) VALUES ('".$designationBatiment."','".$designationEtage."','".$numImmobilier."','".$RefBatiment."')";

    $res=$con->prepare($sqlInsert);
    $res->execute();
    $response = array();
    $code = "success_insert";
    $message = "تم اضافة ".$designationBatiment." الى العقـار ".$numImmobilier." في ".$designationEtage;
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
   
 ?>
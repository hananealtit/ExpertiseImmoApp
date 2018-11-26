<?php
require "init.php";
$numImmobilier = $_POST["numImmobilier"];
$designation_etage = $_POST["designation_etage"];
$response = array();

    $sqlUpdate = "UPDATE immobiliers SET designation_etage = '".$designation_etage."', fermer ='0', louer ='0' WHERE num_immobilier = '".$numImmobilier."'";
    
    $res=$con->prepare($sqlUpdate);
    $res->execute();

    $code = "success_update";
  
           $message =" عقـار يتواجد بالطابق ".$designation_etage;  
           array_push($response,array("code"=>$code,"message"=>$message));
           echo json_encode($response);
        
 ?>
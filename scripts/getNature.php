<?php 
require "init.php";
$numImmobilier = $_POST["numImmobilier"];
$sql = "SELECT natures.designation_nature FROM natures WHERE natures.id_nature = (SELECT immobiliers_natures.natures_id_nature FROM immobiliers_natures WHERE immobiliers_natures.immobiliers_num_immobilier = '".$numImmobilier."')";

$res=$con->prepare($sql);
$res->execute();
$nature = $res->fetch();
$response = array();
if(!empty($nature)){

    $natureImmo = $nature->designation_nature;  
    array_push($response,array("nature"=>$natureImmo));
    echo json_encode($response);   
}


?>
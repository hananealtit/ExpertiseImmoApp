<?php
require "init.php";

$designationSousBatiment = $_POST["designationBatiment"];
$RefBatiment = $_POST["RefBatiment"];
$RefSousBatiment = $_POST["RefSousBatiment"];

    $sqlInsert = "INSERT INTO sous_batiments (designation, ref_batiment,ref_sous_batiment) VALUES ('".$designationSousBatiment."',(SELECT ref_batiment FROM batiments WHERE ref_batiment ='".$RefBatiment."'),'".$RefSousBatiment."')";

    $res=$con->prepare($sqlInsert);
    $res->execute();
    $response = array();
    $code = "success_insert";
    $message = " تم اضافة ".$designationSousBatiment;
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
   
   
 ?>
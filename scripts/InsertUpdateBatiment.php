<?php

require "init.php";

$numImmobilier = $_POST["numImmobilier"];

$designationBatiment = $_POST["designationBatiment"];

$RefBatiment = $_POST["RefBatiment"];



  $sql = "SELECT * from batiments where immobiliers_num_immobilier like '".$numImmobilier."'";

    $res=$con->prepare($sql);
    $res->execute();
    $batiments = $res->fetch();

    if(!empty($batiments)){


   
     $sqlDelete = "DELETE FROM sous_batiments WHERE ref_batiment = (SELECT ref_batiment from batiments WHERE immobiliers_num_immobilier = '".$numImmobilier."')";

     $resDelete=$con->prepare($sqlDelete);

    $resDelete->execute();

     $sqlUpdate= "UPDATE batiments SET designation_batiment = '".$designationBatiment."', ref_batiment = '".$RefBatiment."'  WHERE immobiliers_num_immobilier = '".$numImmobilier."'";
     
    $res=$con->prepare($sqlUpdate);

    $res->execute();

    $response = array();

    $code = "success_insert";

    $message = "تم تحديث ".$designationBatiment." في العقـار ".$numImmobilier;

    array_push($response,array("code"=>$code,"message"=>$message));

    echo json_encode($response);
     
}else {

    $sqlInsert = "INSERT INTO batiments (designation_batiment,immobiliers_num_immobilier, ref_batiment) VALUES ('".$designationBatiment."','".$numImmobilier."','".$RefBatiment."')";



    $res=$con->prepare($sqlInsert);

    $res->execute();

    $response = array();

    $code = "success_insert";

    $message = "تم اضافة ".$designationBatiment." الى العقـار ".$numImmobilier;

    array_push($response,array("code"=>$code,"message"=>$message));

    echo json_encode($response);

   }

   

 ?>
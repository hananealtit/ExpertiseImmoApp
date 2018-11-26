<?php
require "init.php";
$num_dossier= $_POST["dossier_num"];
$num_jugement= $_POST["jugement_num"];


$response =[];
$tab = [];


$sqlAut ="SELECT  jugements_autres.autres_id_autre FROM  jugements_autres WHERE jugements_num_jugement = '".$num_jugement."' AND jugements_dossiers_num_dossier = '".$num_dossier."'";


$res=$con->prepare($sqlAut);
$res->execute();
$autres=$res->fetchAll();


foreach($autres as $autre){

   $sql ="SELECT description_autre from autres WHERE id_autre = '".$autre->autres_id_autre."'";  
   $res=$con->prepare($sql);
   $res->execute();
   $response=$res->fetchAll();
   
   foreach($response as $item){
     
      array_push($tab,array("id"=>$autre->autres_id_autre,"name"=>$item->description_autre));
   
   }
    
}

  echo json_encode(array('autres' => $tab));


?>
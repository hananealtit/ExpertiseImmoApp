<?php
require "init.php";
$num_dossier= '6-6';
$num_jugement= '6/6';

//$num_dossier= $_POST["dossier_num"];
//$num_jugement= $_POST["jugement_num"];


$response =[];
$responseAv =[];
$tab = [];
$avocats = [];

$sqlDef ="SELECT jugements_defendeurs.defendeurs_id_defendeur FROM jugements_defendeurs WHERE jugements_num_jugement = '".$num_jugement."' AND jugements_dossiers_num_dossier = '".$num_dossier."'";


$res=$con->prepare($sqlDef);
$res->execute();
$defendeurs=$res->fetchAll();


foreach($defendeurs as $defendeur){

   $sql ="SELECT nom_defendeur from defendeurs WHERE id_defendeur = '".$defendeur->defendeurs_id_defendeur."'";  
   $res=$con->prepare($sql);
   $res->execute();
   $response=$res->fetchAll();

   $sqlAvocat ="SELECT id_avocat , nom_avocat from avocats WHERE id_avocat IN (SELECT avocats_id_avocat from defendeurs_avocats WHERE defendeurs_id_defendeur = '".$defendeur->defendeurs_id_defendeur."' )";  
   $resAv=$con->prepare($sqlAvocat);
   $resAv->execute();
   $responseAv=$resAv->fetchAll();
   
    if(!empty($responseAv)){
   foreach($response as $item){
    
     foreach($responseAv as $Av){
     
     
      array_push($tab,array("id"=>$defendeur->defendeurs_id_defendeur,"name"=>$item->nom_defendeur , "avocatId"=> $Av->id_avocat , "avocatNom"=> $Av->nom_avocat));
   
   }
    
   }

  }else{

     foreach($response as $item){
    
   
     
      array_push($tab,array("id"=>$defendeur->defendeurs_id_defendeur,"name"=>$item->nom_defendeur , "avocatNom"=> ""));

   
  
}
} 
  
}

echo json_encode(array('defendeurs' => $tab));
//var_dump($tab);


?>
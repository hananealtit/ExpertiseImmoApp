<?php
require "init.php";
$num_dossier= $_POST["dossier_num"];
$num_jugement= $_POST["jugement_num"];


$response =[];
$responseAv =[];
$tab = [];


$sqlProc ="SELECT jugements_procureurs.procureurs_id_procureur FROM jugements_procureurs WHERE jugements_num_jugement = '".$num_jugement."' AND jugements_dossiers_num_dossier = '".$num_dossier."'";


$res=$con->prepare($sqlProc);
$res->execute();
$procureurs=$res->fetchAll();


foreach($procureurs as $procureur){

   $sql ="SELECT nom_procureur from procureurs WHERE id_procureur = '".$procureur->procureurs_id_procureur."'";  
   $res=$con->prepare($sql);
   $res->execute();
   $response=$res->fetchAll();

   $sqlAvocat ="SELECT id_avocat , nom_avocat from avocats WHERE id_avocat IN (SELECT avocats_id_avocat from procureurs_avocats WHERE procureurs_id_procureur = '".$procureur->procureurs_id_procureur."' )";  
   $resAv=$con->prepare($sqlAvocat);
   $resAv->execute();
   $responseAv=$resAv->fetchAll();
   
    if(!empty($responseAv)){
   foreach($response as $item){
    
     foreach($responseAv as $Av){
     
      array_push($tab,array("id"=>$procureur->procureurs_id_procureur,"name"=>$item->nom_procureur , "avocatId"=> $Av->id_avocat , "avocatNom"=> $Av->nom_avocat));
   
   }

   }

  }else{

     foreach($response as $item){
    
   
     
      array_push($tab,array("id"=>$procureur->procureurs_id_procureur,"name"=>$item->nom_procureur , "avocatNom"=> ""));

   
  
}
} 
  
}

  echo json_encode(array('procureurs' => $tab));

?>
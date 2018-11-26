<?php
require "init.php";
//$num_dossier= $_POST["dossier_num"];
//$num_jugement= $_POST["jugement_num"];

$num_dossier= '5-5';
$num_jugement= '5/5';

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
   



   
   foreach($response as $item){

      $sqlAvocat ="SELECT nom_avocat from avocats WHERE id_avocat IN (SELECT avocats_id_avocat from defendeurs_avocats WHERE defendeurs_id_defendeur = '".$defendeur->defendeurs_id_defendeur."' )";  
   $resAv=$con->prepare($sqlAvocat);
   $resAv->execute();
   $responseAv=$resAv->fetchAll();    

if(!empty($responseAv)){
     
   foreach($responseAv as $Av){
     
  
         array_push($avocats, array("n"=>$Av->nom_avocat) );
           

     // array_push($tab,array("id"=>$defendeur->defendeurs_id_defendeur,"name"=>$item->nom_defendeur, "avocat"=> $avocats ));

   }
var_dump($avocats); 

 
}else{

  foreach($response as $item){
    
   
     
     // array_push($tab,array("id"=>$defendeur->defendeurs_id_defendeur,"name"=>$item->nom_defendeur, "avocat"=> "" ));

   
  
}
}

}


  
 
}

//echo json_encode(array('defendeurs' => $tab));




?>
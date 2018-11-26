<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";
$sql ="SELECT dossiers.num_dossier, jugements.num_jugement FROM dossiers INNER JOIN jugements ON dossiers.num_dossier=jugements.dossiers_num_dossier WHERE jugements.dossiers_num_dossier= dossiers.num_dossier";
$global=[];
$resultArr2=[];
$res=$con->prepare($sql);
$res->execute();
$lines=$res->fetchAll();
foreach($lines as $line){
 $sql2= "SELECT immobiliers.designation_immobilier, immobiliers.adresse_immobilier,natures.designation_nature FROM jugements , immobiliers, natures, immobiliers_natures WHERE immobiliers.jugements_dossiers_num_dossier= '".$line->num_dossier."' AND jugements.num_jugement = '".$line->num_jugement."' AND immobiliers_natures.natures_id_nature = natures.id_nature AND immobiliers_natures.immobiliers_num_immobilier = immobiliers.num_immobilier";
    $resulta=$con->prepare($sql2);
    $resulta->execute();
    $r=$resulta->fetchAll();
     $obj_merged = [(object) array_merge((array)($line), (array) array("immobiliers" => $r))];
$global[]=$obj_merged;
}
  echo json_encode(array('convocations' => $global));
?>
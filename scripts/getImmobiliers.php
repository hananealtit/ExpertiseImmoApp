<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";
$num_dossier= $_POST["num_dossier"];
$num_jugement= $_POST["num_jugement"];

//$num_dossier='16-1201-2595';
//$num_jugement= '693';

$sql ="SELECT immobiliers.num_immobilier,immobiliers.designation_immobilier, immobiliers.adresse_immobilier FROM  immobiliers WHERE immobiliers.jugements_dossiers_num_dossier= '".$num_dossier."' AND immobiliers.jugements_num_jugement = '".$num_jugement."'";
$res=$con->prepare($sql);
$res->execute();
$lines=$res->fetchAll();
echo json_encode(array('immobiliers' => $lines));
?>
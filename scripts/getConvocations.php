<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";
$sql ="SELECT dossiers.num_dossier, jugements.num_jugement, date(jugements.date_jugement), jugements.nbr_immobilier FROM dossiers INNER JOIN jugements ON dossiers.num_dossier=jugements.dossiers_num_dossier WHERE jugements.dossiers_num_dossier= dossiers.num_dossier and dossiers.etat_dossier ='non terminer' and etat = '1'";
$res=$con->prepare($sql);

$res->execute();


//echo "$num_rows Rows\n";

$lines=$res->fetchAll();
$size = count($lines);

 
  echo json_encode(array('convocations' => $lines));
?>
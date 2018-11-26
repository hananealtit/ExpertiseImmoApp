<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";

$ref_sous_bat= $_POST["refSousBatiment"];
//$ref_sous_bat ='SousBat_20180117_164209';

$sql ="SELECT sous_batiments.designation, sous_batiments.surface, sous_batiments.img, sous_batiments.fermer, sous_batiments.louer, sous_batiments.prix_location, sous_batiments.description from sous_batiments WHERE sous_batiments.ref_sous_batiment ='".$ref_sous_bat."'";

$res=$con->prepare($sql);
$res->execute();
$lines=$res->fetchAll();
echo json_encode($lines);
?>
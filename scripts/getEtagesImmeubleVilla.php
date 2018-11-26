<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";

$num_immobilier= $_POST["num_immobilier"];


$sql ="SELECT  DISTINCT batiments.designation_etage FROM batiments WHERE batiments.immobiliers_num_immobilier = '".$num_immobilier."'";
$res=$con->prepare($sql);
$res->execute();
$lines=$res->fetchAll();

if(!empty($lines)) {

$resultat =[];
foreach ($lines as $value){

$sqlEtage ="SELECT batiments.ref_batiment, batiments.designation_batiment, batiments.surface, batiments.img_batiment FROM batiments WHERE batiments.designation_etage = '".$value->designation_etage."' AND batiments.immobiliers_num_immobilier = '".$num_immobilier."'";
$resE=$con->prepare($sqlEtage );
$resE->execute();
$batimentsDEtage=$resE->fetchAll();
  
       $bat[]=array($value->designation_etage=>$batimentsDEtage);
       
 }
 echo json_encode(array('etages'=>$bat));

}

?>
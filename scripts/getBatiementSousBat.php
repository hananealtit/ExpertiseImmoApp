<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "init.php";

$ref_batiment= $_POST["ref_batiment"];

//$ref_batiment='App_20180118_165429';

$sql ="SELECT batiments.designation_batiment, batiments.surface, batiments.img_batiment, batiments.fermer, batiments.louer, batiments.prix_location, batiments.description from batiments WHERE batiments.ref_batiment ='".$ref_batiment."'";
$res=$con->prepare($sql);
$res->execute();
$bat=$res->fetchAll();

$response=[];

if(!empty($bat)) {

foreach ($bat as $value){
   
$sqlSousBat="SELECT sous_batiments.ref_sous_batiment,sous_batiments.designation, sous_batiments.surface, sous_batiments.img, sous_batiments.fermer, sous_batiments.louer, sous_batiments.prix_location, sous_batiments.description from sous_batiments WHERE sous_batiments.ref_batiment ='".$ref_batiment."'";
$resB=$con->prepare($sqlSousBat);
$resB->execute();
$sousBat=$resB->fetchAll();
     

}
array_push($response,array("designation_batiment"=>$value->designation_batiment,"surface"=>$value->surface,"img"=>$value->img_batiment,"fermer"=>$value->fermer,"louer"=>$value->louer,"prix_location"=>$value->prix_location,"description"=>$value->description,"sousBatiment"=>$sousBat));
echo json_encode(array('batiments'=>$response));
}

?>
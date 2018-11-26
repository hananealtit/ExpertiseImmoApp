<?php
require "init.php";
$date= $_POST["date_expertise"];
$heure= $_POST["heure_expertise"];
$num_jugement =$_POST["num_jugement"];
$num_dossier=$_POST["num_dossier"];
$heure_convocation_letter =$_POST["heure_convocation_letter"];
$addressExpertise =$_POST["addressExpertise"];
$response = array();

if ($addressExpertise != 'المكتب'){

$code = "v_success_insert";
   $sqlUpdate = "UPDATE convocations SET convocations.date_convocation = '".$date." ".$heure.":00', convocations.heure_convocation = '".$heure_convocation_letter."', convocations.lieu_convocation = '".$addressExpertise."' WHERE convocations.jugements_dossiers_num_dossier = '".$num_dossier."' AND convocations.jugements_num_jugement = '".$num_jugement."'";
   $res2=$con->prepare($sqlUpdate);
   $res2->execute();
$sqlFinish = "UPDATE dossiers SET dossiers.etat_dossier = 'terminé' WHERE dossiers.num_dossier = '".$num_dossier."'";
$resF = $con->prepare($sqlFinish);
$resF->execute();
   $r = array();
   $message = "تمت اضافة التاريخ و الساعة بنجاح";
array_push($response,array("code"=>$code,"message"=>$message));

}

elseif ($addressExpertise == 'المكتب') {

	$code = "v_success_insert";
   $sqlUpdate = "UPDATE convocations SET convocations.date_convocation = '".$date." ".$heure.":00', convocations.heure_convocation = '".$heure_convocation_letter."', convocations.lieu_convocation = '".$addressExpertise."' WHERE convocations.jugements_dossiers_num_dossier = '".$num_dossier."' AND convocations.jugements_num_jugement = '".$num_jugement."'";
   $res2=$con->prepare($sqlUpdate);
   $res2->execute();
$sqlFinish = "UPDATE dossiers SET dossiers.etat_dossier = 'terminé' WHERE dossiers.num_dossier = '".$num_dossier."'";
$resF = $con->prepare($sqlFinish);
$resF->execute();
   $r = array();
   $message = "تمت اضافة التاريخ و الساعة بنجاح";
array_push($response,array("code"=>$code,"message"=>$message));
}
echo json_encode(array('response' => $response));
?>
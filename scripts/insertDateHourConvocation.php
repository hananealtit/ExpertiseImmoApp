<?php
require "init.php";
$date= $_POST["date_expertise"];
$heure= $_POST["heure_expertise"];
$num_jugement =$_POST["num_jugement"];
$num_dossier=$_POST["num_dossier"];
$heure_convocation_letter =$_POST["heure_convocation_letter"];
$addressExpertise =$_POST["addressExpertise"];

//$date= "2017-06-30";
//$heure= "15:00";
$var = "'".$date." ".$heure.":00"."'";
 $response = array();

$sqlSameDateHour = "SELECT * FROM convocations WHERE TIMESTAMPDIFF(MINUTE, convocations.date_convocation, $var) = 0 and date(convocations.date_convocation) = '".$date."'";
$res=$con->prepare($sqlSameDateHour);
$res->execute();
$expertise = $res->fetch();

$sqlBeforeHour = "SELECT * FROM convocations WHERE TIMESTAMPDIFF(MINUTE, convocations.date_convocation, $var) BETWEEN 1 AND 60 AND date(convocations.date_convocation) = '".$date."'";
$res1=$con->prepare($sqlBeforeHour);
$res1->execute();
$expertiseBeforeHour = $res1->fetchAll();

$sqlAfterHour = "SELECT * FROM convocations WHERE TIMESTAMPDIFF(MINUTE, convocations.date_convocation, $var) BETWEEN -60 AND -1 AND date(convocations.date_convocation) = '".$date."'";
$res2=$con->prepare($sqlAfterHour);
$res2->execute();
$expertiseAfterHour = $res2->fetchAll();




if(!empty($expertise)) {
 // same date and Hour
    $code = "v_failed";
    
$message = "تاريخ وساعة ملف عـدد"." ".$expertise->jugements_dossiers_num_dossier." حكم رقم"." ".$expertise->jugements_num_jugement." "." هو نفس التاريخ و الساعة التي قمت باختيارها";

    array_push($response,array("code"=>$code,"message"=>$message));
   
}

if(!empty($expertiseBeforeHour)){

  foreach($expertiseBeforeHour as $row){
   
 
$sql = "select TIMESTAMPDIFF(MINUTE, convocations.date_convocation, $var) AS time FROM convocations WHERE convocations.jugements_dossiers_num_dossier like '".$row->jugements_dossiers_num_dossier."'";


$code = "v_failed_beforehour";
$res=$con->prepare($sql);
$res->execute();
$resp = $res->fetch();

$row->minute = $resp->time;


$r = array();

$message = " ملف عـدد"." ".$row->jugements_dossiers_num_dossier." حكم رقم"." ".$row->jugements_num_jugement." "." قبل"." ".$row->minute." "." دقيقة ";
array_push($response,array("code"=>$code,"message"=>$message));

  }
 
}

if(!empty($expertiseAfterHour)){

  foreach($expertiseAfterHour as $row){
   
 
$sql = "select TIMESTAMPDIFF(MINUTE, convocations.date_convocation, $var) AS time FROM convocations WHERE convocations.jugements_dossiers_num_dossier like '".$row->jugements_dossiers_num_dossier."'";


$code = "v_failed_afterhour";
$res=$con->prepare($sql);
$res->execute();
$resp = $res->fetch();

$row->minute = $resp->time * (-1);

$r = array();

$message = " ملف عـدد"." ".$row->jugements_dossiers_num_dossier." حكم رقم"." ".$row->jugements_num_jugement." "." بعد"." ".$row->minute." "." دقيقة";

array_push($response,array("code"=>$code,"message"=>$message));
  }


    
}

 if(empty($expertiseAfterHour) and empty($expertiseBeforeHour) and empty($expertise)){

	if ($addressExpertise != 'المكتب'){

   $code = "v_success";
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

	$code = "v_success";
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


    }

echo json_encode(array('response' => $response));

 ?>
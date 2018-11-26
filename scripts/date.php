<?php
// مدة البيان
$bayan_ikhbari = strtotime("2017-08-01");
$jawab_bayan = strtotime("2017-08-21");
$datediff = $jawab_bayan - $bayan_ikhbari;
$duree_declaration = floor($datediff / (60 * 60 * 24)) + 30;
echo "duree declaration = ".$duree_declaration. " jours";
echo "<br>" ;
// soit 30 jours duree expertise
$duree_expertise = 30;
$duree = $duree_declaration + $duree_expertise;
echo "duree ".$duree ;
echo "<br>" ;
// tarikh  ida3
// $Date_arrivee equivalent  tarikh tawasol
$Date_arrivee = "2017-07-01";
echo ("tarikh ida3 ");
echo date('Y-m-d', strtotime($Date_arrivee. ' + '.$duree.' days'));

?>

<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php

$host="localhost";
$db_user="guima1_gui4";
$db_password = "evm5pt89qo9z";
$db_name= "guima1_gui4";

$con=new PDO("mysql:host=$host;dbname=$db_name;charset=UTF8",$db_user,$db_password);
                $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
         

?>
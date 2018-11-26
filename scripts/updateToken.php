<?php

require "init.php";
$token= $_POST["token"];
//$username = $_POST["name"];


$sql = "UPDATE users SET token_notification = '".$token."'";
$res=$con->prepare($sql);
$res->execute();


 ?>
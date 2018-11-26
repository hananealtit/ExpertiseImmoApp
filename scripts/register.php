<?php
require "init.php";
$name = $_POST["name"];
$email= $_POST["email"];
$password = $_POST["password"];
$sql = "select * from users where email like '".$email."';";
//$result= mysqli_query($con,$sql);
$res=$con->prepare($sql);
$res->execute();
$user = $res->fetch();
$response = array();

if(!empty($user)) {
    $code = "reg_failed";
    $message = "البريد الالكتروني مسجل سابقا";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
} else {
   
    $sql = "insert into users (name, email, password) values ('".$name."','".$email."','".$password."')";
   // $result= mysqli_query($con,$sql);
$res=$con->prepare($sql);
$res->execute();
    $code = "reg_success";
    $message = "شكرا على تسجيلكم, يمكنكم الان تسجيل الدخول باستخدام البريد الالكتروني و كلمة السر";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);
    }
   
 ?>
<?php 
require "init.php";
// $_POST["email"] email correspond à getParams .put
$email= $_POST["email"];
$password = $_POST["password"];
$sql = "select name,email from users where email like '".$email."' and password like '".$password."';";
//$result = mysqli_query($con,$sql);
$res=$con->prepare($sql);
$res->execute();
$user = $res->fetch();
$response = array();
if(!empty($user)){
  //  $row = mysqli_fetch_row($result);

    $name = $user->name;
    $email = $user->email;
    $code = "login success";
    array_push($response,array("code"=>$code,"name"=>$name, "email"=>$email));
    echo json_encode($response);   
}
else {
    $code = "login_failed";
    $message = " لم يتم العثور على أي حساب بعنوان البريد الالكتروني هذا, يرجى التحقق من معلومات حسابكم";
    array_push($response,array("code"=>$code,"message"=>$message));
    echo json_encode($response);


}


?>
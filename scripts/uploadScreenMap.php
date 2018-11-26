<?php

require "init.php";
$target_dir = "uploads/maps";

$image = $_POST["image"];
$num_immobilier = $_POST["num_immobilier"];

if(!file_exists($target_dir)){

    

    // create upload image folder

    mkdir($target_dir, 0777, true);

  }  

    

    // set ramdom image file name with time
   
   $name_pic = rand()."_".time().".jpeg";

    $target_dir = $target_dir."/".$name_pic;

    if(file_put_contents($target_dir, base64_decode($image))){

        $sqlUpdate = "UPDATE immobiliers SET img_map ='".$name_pic."' WHERE num_immobilier = '".$num_immobilier."'";

        

        $res=$con->prepare($sqlUpdate);

        $res->execute();

        echo  " تم تحـديث الـصـورة بنـجاح ";

     /*   echo json_encode([



    "Message" => "The file has been uploaded",

    "Status" => "OK"



         ]);

        */ 

    } else {

        echo  " عذرا، لم يتم تحميل الصورة ";
/*
        echo json_encode([

        

         "Message" => "Sorry, The file has not been uploaded",

         "Status" => "Error"



        ]);

*/
    }

   

?>
<?php

require "init.php";

$target_dir = "uploads/pictures";

$image = $_POST["image"];

/**/

$num_immobilier= $_POST["num_immobilier"];

if(!file_exists($target_dir)){

    

    // create upload image folder

    mkdir($target_dir, 0777, true);

  }  

    // set ramdom image file name with time

    /**/

    $target_pic_name = rand()."_".time().".jpeg";

    $target_dir = $target_dir."/".$target_pic_name;

    if(file_put_contents($target_dir, base64_decode($image))){

        $sqlUpdate = "UPDATE immobiliers SET img_immobilier ='".$target_pic_name."' WHERE num_immobilier = '".$num_immobilier."'";

       
        $res=$con->prepare($sqlUpdate);

        $res->execute();

        echo  " تم تحـديث الـصـورة بنـجاح ";

    /*    echo json_encode([



    "Message" => "تم تحميل الصورة بنجاح",


         ]);

    */     

    } else {
       
       echo  " عذرا، لم يتم تحميل الصورة ";

     /*   echo json_encode([

         "Message" => "خطأ لم يتم تحميل الصورة",

         "Status" => "Error"



        ]); 
*/     

    }

?>
<?php

require "init.php";

$target_dir = "uploads/pictures";

$image = $_POST["image"];

/**/

$refBatiment= $_POST["refBatiment"];

if(!file_exists($target_dir)){

    

    // create upload image folder

    mkdir($target_dir, 0777, true);

  }  

    

    // set ramdom image file name with time

    /**/

    $target_pic_name = rand()."_".time().".jpeg";

    $target_dir = $target_dir."/".$target_pic_name;

    if(file_put_contents($target_dir, base64_decode($image))){

        $sqlUpdate = "UPDATE batiments SET img_batiment ='".$target_pic_name."' WHERE ref_batiment = '".$refBatiment."'";

        

        $res=$con->prepare($sqlUpdate);

        $res->execute();

        

      //  echo $target_dir;

      //  echo $target_pic_name;

        echo  " تم تحـديث الـصـورة بنـجاح ";

      /*  echo json_encode([



    "Message" => "The file has been uploaded",

    "Status" => "OK"



         ]);

         */

    } else {

         echo  " عذرا، لم يتم تحميل الصورة ";

     /*   echo json_encode([

        

         "Message" => "Sorry, The file has not been uploaded",

         "Status" => "Error"



        ]);
*/

    }

    
?>
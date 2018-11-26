<?php

require "init.php";

$target_dir = "uploads/pictures";

$image = $_POST["image"];

/**/

$refSousBatiment= $_POST["refSousBatiment"];

if(!file_exists($target_dir)){

    

    // create upload image folder

    mkdir($target_dir, 0777, true);

  }  

    

    // set ramdom image file name with time

    /**/

    $target_pic_name = rand()."_".time().".jpeg";

    $target_dir = $target_dir."/".$target_pic_name;

    if(file_put_contents($target_dir, base64_decode($image))){

        $sqlUpdate = "UPDATE sous_batiments SET img ='".$target_pic_name."' WHERE ref_sous_batiment = '".$refSousBatiment."'";

        

        $res=$con->prepare($sqlUpdate);

        $res->execute();

        

      //  echo $target_dir;

      //  echo $target_pic_name;

        echo  " تم تحـديث الـصـورة بنـجاح ";

     /*   echo json_encode([



    "Message" => "The file has been uploaded",

    "Status" => "OK"



         ]);

       */  

    } else {

        echo  " تم تحـديث الـصـورة بنـجاح ";

     /*   echo json_encode([

        

         "Message" => "عذرا، لم يتم تحميل الصورة",

         "Status" => "Error"



        ]);

        */

        

        

    }

    

    





?>
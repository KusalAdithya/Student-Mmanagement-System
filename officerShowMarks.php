<?php
session_start();

require "connection.php";

if (isset($_SESSION["officer"])) {
    $officer = $_SESSION["officer"];

    $result_id = $_POST["rid"];

    if (preg_match('/[1][2-3]/', $officer['grade_id'])) {  //show A/L assinment results

        $AS_r = Database::search("SELECT * FROM `a/l_results` WHERE `a/l_results`.`id`='".$result_id."' ");
        $num = $AS_r->num_rows;

        if($num ==1){
            $row = $AS_r->fetch_assoc();
            $status = $row["status_id"];

            if($status =="2"){ //show
                $show = Database::iud("UPDATE `a/l_results` SET `a/l_results`.`status_id`='1' WHERE `a/l_results`.`id`='".$result_id."' ");
                echo "success2";
            }else{ //hide
                $show = Database::iud("UPDATE `a/l_results` SET `a/l_results`.`status_id`='2' WHERE `a/l_results`.`id`='".$result_id."' ");
                echo "success1";
            }

           
        }

    }else{      //show not A/L assinment results

        $AS_r = Database::search("SELECT * FROM `results` WHERE `results`.`id`='".$result_id."' ");
        $num = $AS_r->num_rows;

        if($num ==1){

            $row = $AS_r->fetch_assoc();
            $status = $row["status_id"];

            if($status =="2"){ //show
                $show = Database::iud("UPDATE `results` SET `results`.`status_id`='1' WHERE `results`.`id`='".$result_id."' ");
                echo "success2";
            }else{//hide
                $show = Database::iud("UPDATE `results` SET `results`.`status_id`='2' WHERE `results`.`id`='".$result_id."' ");
                echo "success1";
            }
          
        }   
        
    }

}
?>
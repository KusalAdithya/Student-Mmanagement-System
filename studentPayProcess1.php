<?php
session_start();
require "connection.php";

$Sid = $_POST["Sid"];
$pay = $_POST["pay"];

$payr = Database::search("SELECT * FROM `student_payment` WHERE `student_s_ad_no`='" . $Sid . "' ");
$pay_n = $payr->num_rows;

if($pay_n==1){
    if ($pay != "1000") {
        echo "You need to pay Rs.1000";
    } else {

        $pay_nrs = $payr->fetch_assoc();
        if( $pay_nrs["payment"]=="1000"){
            echo "ok2";
        }else{

            $setPay = Database::iud("UPDATE `student_payment` SET `payment`='1000' WHERE `student_s_ad_no`='" . $Sid . "' ");  //set payment
    
            $cd = Database::search("SELECT * FROM `student` WHERE `s_ad_no`='" . $Sid . "' "); //add to session
            $cn = $cd->fetch_assoc();
            $_SESSION["student"] = $cn;
        
            echo "Success";
        }

    }
}else{
    echo "ok1";
}



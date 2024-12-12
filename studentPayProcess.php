<?php
session_start();
require "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$pay = $_POST["pay"];


if($pay != "1000"){
    echo "You need to pay Rs.1000";
}else{
    $rs = Database::search("SELECT * FROM `student` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");  
    $n = $rs->num_rows;

    if ($n == 1) {
        $s_rs = $rs->fetch_assoc();

        $setPay = Database::iud("UPDATE `student_payment` SET `payment`='1000' WHERE `student_s_ad_no`='" . $s_rs['s_ad_no'] . "' ");  //set payment
        
        $cd = Database::search("SELECT * FROM `student` WHERE `s_ad_no`='" .$s_rs['s_ad_no'] . "' "); //add to session
        $cn = $cd->fetch_assoc();
        $_SESSION["student"] = $cn;

        echo "Success";
    } else {
        echo "Invalid details";
    }
}

?>
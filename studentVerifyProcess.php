<?php
session_start();
require "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$vcode = $_POST["vcode"];

if(empty($vcode)){
    echo "Please enter your Verification Code";
}else{
    $rs = Database::search("SELECT * FROM `student` WHERE `email`='" . $username . "' AND `password`='" . $password . "' AND `verification_code`='" . $vcode . "' ");  //first login
    $n = $rs->num_rows;

    if ($n == 1) {
        $dlt_code = Database::iud("UPDATE `student` SET `verification_code`='null' , `status_id`='1' WHERE `email`='" . $username . "' ");  //delete verification code and changed as a verified student

        $newrs = Database::search("SELECT * FROM `student` WHERE `email`='" . $username . "' ");  //get student details
        $x = $newrs->num_rows;

        if ($x == 1) {
            $d = $newrs->fetch_assoc();
            $_SESSION["student"] = $d;
        }
        
        echo "Success";
    } else {
        echo "Invalid details";
    }
}

?>
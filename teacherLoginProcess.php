<?php
session_start();

require "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$remember = $_POST["remember"];


if (empty($username)) {
    echo "Please enter your Email address";
} else if (empty($password)) {
    echo "Please enter your Password";
} else {

    $cd = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");  //check login details
    $cn = $cd->num_rows;

    if ($cn == 1) {

        if ($remember == "true") {   //remember me checked
            setcookie("un", $username, time() + (60 * 60 * 24 * 365));
            setcookie("pw", $password, time() + (60 * 60 * 24 * 365));
        } else {
            setcookie("un", "", -1);
            setcookie("pw", "", -1);
        }

        $d = $cd->fetch_assoc();
        $vcode = $d["verification_code"];

        if ($vcode != "null") {  //first login
            echo "vcode";
        } else {               //second login

            $status = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");
            $sn = $status->num_rows;

            if ($sn = 1) {  //ckeck verified teacher
                $sd = $status->fetch_assoc();
                $sid = $sd["status_id"];

                if ($sid == "1") {
                    $_SESSION["teacher"] = $sd;   
                    echo "second login";
                } else {
                    echo "You are not a Verified Teacher";
                }
            }
        }
    } else {
        echo "Invalid details";
    }
}

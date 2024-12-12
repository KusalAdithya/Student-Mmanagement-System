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

    $cd = Database::search("SELECT * FROM `student` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");  //check login details
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

            $status = Database::search("SELECT * FROM `student` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");
            $sn = $status->num_rows;

            if ($sn = 1) {  //ckeck verified student
                $sd = $status->fetch_assoc();

                //check payment
                $pay = Database::search("SELECT * FROM `student_payment` WHERE `student_s_ad_no`='" . $sd["s_ad_no"] . "' ");
                $pay_n = $pay->num_rows;
                $pay_rs = $pay->fetch_assoc();

                $tdate = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $tdate->setTimezone($tz);
                $today = $tdate->format("Y-m-d H:i:s");

                if ($pay_n == 1) {
                    if ($pay_rs["payment"] == "0") {
                        
                        if ($today >= $pay_rs["end"]) {
                            echo "dopayment";
                        }else{
                            $sid = $sd["status_id"];

                            if ($sid == "1") {
                                $_SESSION["student"] = $sd;
            
                                echo "payment";
                            } else {
                                echo "You are not a Verified Student";
                            }

                        }
                    }else{
                        $sid = $sd["status_id"];

                        if ($sid == "1") {
                            $_SESSION["student"] = $sd;
        
                            echo "second login";
                        } else {
                            echo "You are not a Verified Student";
                        }
                    }
                } else {
                    $sid = $sd["status_id"];

                    if ($sid == "1") {
                        $_SESSION["student"] = $sd;
    
                        echo "second login";
                    } else {
                        echo "You are not a Verified Student";
                    }
                }

               
            }
        }
    } else {
        echo "Invalid details";
    }
}

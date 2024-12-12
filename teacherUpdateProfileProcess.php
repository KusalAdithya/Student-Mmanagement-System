<?php
session_start();

require "connection.php";

if (isset($_SESSION["teacher"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email)) {
        echo "Please enter your email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
    } else if (strlen($email) > 100) {
        echo "Email must be less than 100 characters";
    } else if (empty($password)) {
        echo "Please enter your password";
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        echo "Password length must between 5 and 20";
    } else if ($email != $_SESSION["teacher"]["email"]) { //update email & password

        $check = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $email . "' ");
        $checkr = $check->num_rows;

        if ($checkr == 1) {
            echo "This email is already taken!";
        } else {
            $update = Database::iud("UPDATE `teacher` SET `email`='" . $email . "' , `password`='" . $password . "' WHERE `t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

            if (isset($_COOKIE["un"]) && isset($_COOKIE["pw"])) {
                setcookie("un", "", -1);
                setcookie("pw", "", -1);
            }

            $newrs = Database::search("SELECT * FROM `teacher` WHERE `t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");
            $d = $newrs->fetch_assoc();

            setcookie("un", $email, time() + (60 * 60 * 24 * 365));
            setcookie("pw", $password, time() + (60 * 60 * 24 * 365));

            $_SESSION["teacher"] = $d;

            echo "ok";
        }
    } else {  //update only password

        $update = Database::iud("UPDATE `teacher` SET `password`='" . $password . "' WHERE `t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

        if (isset($_COOKIE["un"]) && isset($_COOKIE["pw"])) {
            setcookie("un", "", -1);
            setcookie("pw", "", -1);
        }

        $newrs = Database::search("SELECT * FROM `teacher` WHERE `t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");
        $d = $newrs->fetch_assoc();
        $_SESSION["teacher"] = $d;

        setcookie("un", $email, time() + (60 * 60 * 24 * 365));
        setcookie("pw", $password, time() + (60 * 60 * 24 * 365));

        echo "ok";
    }
}
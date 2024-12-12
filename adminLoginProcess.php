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

    $cd = Database::search("SELECT * FROM `admin` WHERE `email`='" . $username . "' AND `password`='" . $password . "' ");  //check login details
    $cn = $cd->num_rows;

    if ($cn == 1) {

        if ($remember == "true") {   //remember me checked
            setcookie("un", $username, time() + (60 * 60 * 24 * 365));
            setcookie("pw", $password, time() + (60 * 60 * 24 * 365));
        } else {
            setcookie("un", "", -1);
            setcookie("pw", "", -1);
        }

        $row = $cd->fetch_assoc();

        $_SESSION["admin"] = $row;
        echo "ok";

    } else {
        echo "Invalid details";
    }
}

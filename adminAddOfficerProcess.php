<?php
session_start();

require "connection.php";

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION["admin"])) {

    $O_AdN = $_POST["O_AdN"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $Ograde = $_POST["Ograde"];

    if (empty($O_AdN)) {
        echo "Please enter Officer admission number";
    } else if (preg_match('/[^0-9]/', $O_AdN)) {
        echo "Please enter valid admission number";
    } else if (empty($fname)) {
        echo "Please enter Officer first name";
    } else if (empty($lname)) {
        echo "Please enter Officer last name";
    } else if (empty($email)) {
        echo "Please enter Officer email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
    } else if (strlen($email) > 100) {
        echo "Email must be less than 100 characters";
    } else if (empty($password)) {
        echo "Please enter Officer password";
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        echo "Password length must between 5 and 20";
    } else if ($Ograde == "0") {
        echo "Please select Service Grade";
    } else {
      
        $check = Database::search("SELECT * FROM `ac_officer` WHERE `ac_ad_no`='" . $O_AdN . "' "); //check already exists officer
        $checkr = $check->num_rows;

        if ($checkr == 1) {
            echo "This Officer admission number is already exists !";
        } else {     //add new officer

            $code = uniqid(); //get unique id for verification code

            //register officer
            $adOfficer = Database::iud("INSERT INTO `ac_officer` (`ac_ad_no`,`email`,`fname`,`lname`,`password`,`verification_code`,`status_id`,`grade_id`) VALUES ('" . $O_AdN . "' ,'" . $email . "','" . $fname . "','" . $lname . "' ,'" . $password . "' ,'" . $code . "','1','" . $Ograde . "') ");

            //send email to officer
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kamalpere11@gmail.com';
            $mail->Password = 'dlasxdtdnpmzsbdr';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('kamalpere11@gmail.com', 'Philip Neri College');
            $mail->addReplyTo('kamalpere11@gmail.com', 'Philip Neri College');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Philip Neri College Academic Officer Login';
            $bodyContent = '<h3>Username : ' . $email . '</h3> 
            <h3>Password: ' . $password . '</h3>
            <h3>Verification Code: ' . $code . '</h3>
            <h3>Web site link : http://localhost/osms/officerLogin.php</h3>
            <h5>Do not shere this with anyone!</h5> ';
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {
                echo 'Verification code sending fail';
            } else {
                echo "ok";
            }

        }
    }
}

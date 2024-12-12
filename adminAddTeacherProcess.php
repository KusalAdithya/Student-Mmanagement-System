<?php
session_start();

require "connection.php";

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION["admin"])) {

    $T_AdN = $_POST["T_AdN"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $selectSection = $_POST["selectSection"];

    if (empty($T_AdN)) {
        echo "Please enter teacher admission number";
    } else if (preg_match('/[^0-9]/', $T_AdN)) {
        echo "Please enter valid admission number";
    } else if (empty($fname)) {
        echo "Please enter teacher first name";
    } else if (empty($lname)) {
        echo "Please enter teacher last name";
    } else if (empty($email)) {
        echo "Please enter teacher email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
    } else if (strlen($email) > 100) {
        echo "Email must be less than 100 characters";
    } else if (empty($password)) {
        echo "Please enter password";
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        echo "Password length must between 5 and 20";
    } else if ($selectSection == "0") {
        echo "Please select Section";
    } else {

        $check = Database::search("SELECT * FROM `teacher` WHERE `t_ad_no`='" . $T_AdN . "' "); //check already exists teacher
        $checkr = $check->num_rows;

        if ($checkr == 1) {
            echo "This Teacher admission number is already exists !";
        } else {     //add new teacher

            $code = uniqid(); //get unique id for verification code

            //register teacher
            $adOfficer = Database::iud("INSERT INTO `teacher` (`t_ad_no`,`email`,`fname`,`lname`,`password`,`section_id`,`verification_code`,`status_id`) VALUES ('" . $T_AdN . "' ,'" . $email . "','" . $fname . "','" . $lname . "' ,'" . $password . "' ,'" . $selectSection . "','" . $code . "','1') ");

            //send email to teacher
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '**********@gmail.com';
            $mail->Password = '**********';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('**********@gmail.com', 'Philip Neri College');
            $mail->addReplyTo('**********@gmail.com', 'Philip Neri College');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Philip Neri College Teacher Login';
            $bodyContent = '<h3>Username : ' . $email . '</h3> 
            <h3>Password: ' . $password . '</h3>
            <h3>Verification Code: ' . $code . '</h3>
            <h3>Web site link : http://localhost/osms/teacherLogin.php</h3>
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

<?php
session_start();

require "connection.php";

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION["officer"])) {

    $A_No = $_POST["A_No"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $grade = $_POST["grade"];

    if (empty($A_No)) {
        echo "Please enter Student admission number";
    } else if (preg_match('/[^0-9]/', $A_No)) {
        echo "Please enter valid admission number";
    }else if (empty($fname)) {
        echo "Please enter Student first name";
    } else if (empty($lname)) {
        echo "Please enter Student last name";
    } else if (empty($email)) {
        echo "Please enter Student email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
    } else if (strlen($email) > 100) {
        echo "Email must be less than 100 characters";
    } else if (empty($password)) {
        echo "Please enter Student password";
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        echo "Password length must between 5 and 20";
    } else {

        $check = Database::search("SELECT * FROM `student` WHERE `s_ad_no`='" . $A_No . "' "); //check already exists student
        $checkr = $check->num_rows;

        if ($checkr == 1) {
            echo "This Student admission number is already exists !";
        } else {     //add new student

            $section_id;   //get section using student grade
            if (preg_match('/[1][2-3]/', $grade)) {
                $section_id = "4";
            } else  if (preg_match('/[1][0-1]/', $grade)) {
                $section_id = "3";
            } else if (preg_match('/[6-9]/', $grade)) {
                $section_id = "2";
            } else if (preg_match('/[1-5]/', $grade)) {
                $section_id = "1";
            }

            $code = uniqid(); //get unique id for verification code

            //register student
            $addStudent = Database::iud("INSERT INTO `student` (`s_ad_no`,`email`,`fname`,`lname`,`password`,`verification_code`,`grade_id`,`status_id`,`section_id`) VALUES ('" . $A_No . "' ,'" . $email . "','" . $fname . "','" . $lname . "' ,'" . $password . "' ,'" . $code . "','" . $grade . "','1','" . $section_id . "') ");

            //send email to student
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
            $mail->Subject = 'Philip Neri College Student Login';
            $bodyContent = '<h3>Username : ' . $email . '</h3> 
            <h3>Password: ' . $password . '</h3>
            <h3>Verification Code: ' . $code . '</h3>
            <h3>Web site link : http://localhost/osms/index.php</h3>
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

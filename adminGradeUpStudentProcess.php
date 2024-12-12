<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $student_id = $_POST["Sid"];

    $student_r = Database::search("SELECT * FROM  `student` WHERE `student`.`s_ad_no`='" . $student_id . "' ");
    $num = $student_r->num_rows;

    if ($num == 1) {
        $row = $student_r->fetch_assoc();
        $grade = $row["grade_id"];

        $new_grade = $grade + 1;

        $section_id;   //get section
        if (preg_match('/[1][2-3]/', $new_grade)) {
            $section_id = "4";
        } else  if (preg_match('/[1][0-1]/', $new_grade)) {
            $section_id = "3";
        } else if (preg_match('/[6-9]/', $new_grade)) {
            $section_id = "2";
        } else if (preg_match('/[1-5]/', $new_grade)) {
            $section_id = "1";
        }

        $grade_up = Database::iud("UPDATE `student` SET `student`.`grade_id`='" . $new_grade . "' AND `student`.`section_id`='".$section_id."' WHERE `student`.`s_ad_no`='" . $student_id . "' ");
        echo $new_grade;

        $student_r1 = Database::search("SELECT * FROM  `student` WHERE `student`.`s_ad_no`='" . $student_id . "' ");
        $d = $student_r1->fetch_assoc();

        $_SESSION["student"] = $d;

        $tdate = new DateTime(); // star date
        $tz = new DateTimeZone("Asia/Colombo");
        $tdate->setTimezone($tz);
        $start = $tdate->format("Y-m-d H:i:s");

        $end = new DateTime('now');  //end date
        $end->modify('+1 month');
        $end = $end->format('Y-m-d h:i:s');


        $pay = Database::iud("INSERT INTO `student_payment`(`student_s_ad_no`,`start`,`end`,`payment`) VALUES ('" . $student_id . "','" . $start . "','" . $end . "','0') ");
    } else {
        echo "Invalid student";
    }
}

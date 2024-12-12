<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $Tid = $_POST["Tid"];
    $s_g = $_POST["s_g"];

    if ($s_g == "0") {
        echo "Please select Subject";
    } else {

        $t = Database::search("SELECT * FROM `teacher` WHERE `t_ad_no`='" . $Tid . "' ");
        $t_n = $t->num_rows;

        if ($t_n == 1) {
            $t_rs = $t->fetch_assoc();

            if ($t_rs["section_id"] == "4") { //A/L

                $tecer_has_al_sub = Database::iud("INSERT INTO `teacher_has_a/l_subjects` (`teacher_t_ad_no`,`grade_has_a/l_subjects_id`) VALUES ('" . $Tid . "' ,'" . $s_g . "') ");

                echo "ok";
            } else { //not A/L

                $tecer_has_al_sub = Database::iud("INSERT INTO `teacher_has_subject` (`teacher_t_ad_no`,`grade_has_subject_id`) VALUES ('" . $Tid . "' ,'" . $s_g . "') ");

                echo "ok";
            }
        }
    }
}

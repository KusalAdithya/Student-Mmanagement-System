<?php

session_start();
require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];

    $resultId = $_POST["resultId"];
    $marks = $_POST["marks"];

    if (empty($marks)) {
        echo "Please enter marks";
    } else if (preg_match('/[^0-9]/', $marks)) {
        echo "Please enter valid marks";
    } else {

        if ($teacher["section_id"] == "4") {  //A/L section

            $resultTable =  Database::search("SELECT * FROM `a/l_results` WHERE `a/l_results`.`id`='" . $resultId . "' ");
            $resultTable_nr = $resultTable->num_rows;

            if ($resultTable_nr == 1) {
                $resultTable_rs = $resultTable->fetch_assoc();

                Database::iud("UPDATE `a/l_results` SET `a/l_results`.`result` ='" . $marks . "' WHERE `a/l_results`.`student_s_ad_no` ='" . $resultTable_rs['student_s_ad_no'] . "' AND `a/l_results`.`a/l_assignment_id` ='" . $resultTable_rs['a/l_assignment_id'] . "' ");

                echo "Marks added successfully";
            }
        } else {  //not A/L

            $resultTable =  Database::search("SELECT * FROM `results` WHERE `results`.`id`='" . $resultId . "' ");
            $resultTable_nr = $resultTable->num_rows;

            if ($resultTable_nr == 1) {
                $resultTable_rs = $resultTable->fetch_assoc();

                Database::iud("UPDATE `results` SET `results`.`result` ='" . $marks . "' WHERE `results`.`student_s_ad_no` ='" . $resultTable_rs['student_s_ad_no'] . "' AND `results`.`assignment_id` ='" . $resultTable_rs['assignment_id'] . "' ");

                echo "Marks added successfully";
            }
        }
    }
}

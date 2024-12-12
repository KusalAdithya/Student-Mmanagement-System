<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $student_id = $_POST["Sid"];

    $student_r = Database::search("SELECT * FROM  `student` WHERE `student`.`s_ad_no`='" . $student_id . "' ");
    $num = $student_r->num_rows;

    if ($num == 1) {
        $row = $student_r->fetch_assoc();
        $status = $row["status_id"];

        if ($status == "2") { //active
            $show = Database::iud("UPDATE `student` SET `student`.`status_id`='1' WHERE `student`.`s_ad_no`='" . $student_id . "' ");
            echo "success2";
        } else { //diactive
            $show = Database::iud("UPDATE `student` SET `student`.`status_id`='2' WHERE `student`.`s_ad_no`='" . $student_id . "' ");
            echo "success1";
        }
    }
}
?>
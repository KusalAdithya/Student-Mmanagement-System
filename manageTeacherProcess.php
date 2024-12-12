<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $teacher_id = $_POST["Tid"];

    $teacher_r = Database::search("SELECT * FROM  `teacher` WHERE `teacher`.`t_ad_no`='" . $teacher_id . "'");
    $num = $teacher_r->num_rows;

    if ($num == 1) {
        $row = $teacher_r->fetch_assoc();
        $status = $row["status_id"];

        if ($status == "2") { //active
            $show = Database::iud("UPDATE `teacher` SET `teacher`.`status_id`='1' WHERE `teacher`.`t_ad_no`='" . $teacher_id . "' ");
            echo "success2";
        } else { //diactive
            $show = Database::iud("UPDATE `teacher` SET `teacher`.`status_id`='2' WHERE `teacher`.`t_ad_no`='" . $teacher_id . "' ");
            echo "success1";
        }
    }
}
?>
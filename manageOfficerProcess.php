<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $officer_id = $_POST["Oid"];

    $officer_r = Database::search("SELECT * FROM  `ac_officer` WHERE `ac_officer`.`ac_ad_no`='" . $officer_id . "' ");
    $num = $officer_r->num_rows;

    if ($num == 1) {
        $row = $officer_r->fetch_assoc();
        $status = $row["status_id"];

        if ($status == "2") { //active
            $show = Database::iud("UPDATE `ac_officer` SET `ac_officer`.`status_id`='1' WHERE `ac_officer`.`ac_ad_no`='" . $officer_id . "' ");
            echo "success2";
        } else { //diactive
            $show = Database::iud("UPDATE `ac_officer` SET `ac_officer`.`status_id`='2' WHERE `ac_officer`.`ac_ad_no`='" . $officer_id . "' ");
            echo "success1";
        }
    }
}
?>
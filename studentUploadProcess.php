<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $student = $_SESSION["student"];

    $asId = $_POST["asID"];

    if (isset($_FILES["uploadFile"])) {

        $uploadFile = $_FILES["uploadFile"];

        $extension = pathinfo($uploadFile["name"], PATHINFO_EXTENSION);

        $fileex = $uploadFile["type"];

        if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
            echo "Please Select a valid file.";
        } else {

            $uniC = uniqid();
            $uploadFileName = "UploadFiles//" . $uniC . $uploadFile["name"];

            $file_name = $uniC . $uploadFile["name"];

            move_uploaded_file($uploadFile["tmp_name"], $uploadFileName);

            if ($student["section_id"] == "4") {  //A/L student

                $Up = Database::search("SELECT * FROM `a/l_results` WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `a/l_assignment_id`='" .  $asId . "' ");
                $Up_nr = $Up->num_rows;

                if ($Up_nr == 1) {  //re upload assigment before end date

                    Database::iud("UPDATE `a/l_results` SET `file`='" .  $file_name . "' WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `a/l_assignment_id`='" .  $asId . "' ");
                
                } else { //upload new assignment

                    Database::iud("INSERT INTO `a/l_results` (`student_s_ad_no`,`a/l_assignment_id`,`file`,`result`,`status_id`) VALUES ('" . $student['s_ad_no'] . "','" . $asId . "','" .  $file_name . "','Pending','2')");
                }

                echo "Assignment submitted successfully";

            } else {  //not A/L

                $Up = Database::search("SELECT * FROM `results` WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `assignment_id`='" .  $asId . "' ");
                $Up_nr = $Up->num_rows;

                if ($Up_nr == 1) {  //re upload assigment before end date

                    Database::iud("UPDATE `results` SET `file`='" .  $file_name . "' WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `assignment_id`='" .  $asId . "' ");

                } else { //upload new assignment

                    Database::iud("INSERT INTO `results` (`student_s_ad_no`,`assignment_id`,`file`,`result`,`status_id`) VALUES ('" . $student['s_ad_no'] . "','" . $asId . "','" .  $file_name . "','Pending','2')");
                }

                echo "Assignment submitted successfully";
            }

        }
    } else {
        echo "Please select a file";
    }
}

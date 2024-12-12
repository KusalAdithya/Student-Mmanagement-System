<?php

session_start();
require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];

    $gsId = $_POST["gsID"];
    $Lname = $_POST["Lname"];

    if (empty($Lname)) {
        echo "Please enter a name";
    } else {

        if (isset($_FILES["addLNote"])) {

            $uploadFile = $_FILES["addLNote"];

            $extension = pathinfo($uploadFile["name"], PATHINFO_EXTENSION);

            $fileex = $uploadFile["type"];

            if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
                echo "Please Select a valid file.";
            } else {

                $uniC = uniqid();
                $uploadFileName = "UploadFiles//" . $uniC . $uploadFile["name"];

                $file_name = $uniC . $uploadFile["name"];

                move_uploaded_file($uploadFile["tmp_name"], $uploadFileName);

                if ($teacher["section_id"] == "4") {  //A/L section

                    Database::iud("INSERT INTO `a/l_notes` (`name`,`file`,`grade_has_a/l_subjects_id`) VALUES ('" . $Lname . "','" .  $file_name . "','" . $gsId . "')");

                    echo "Lesson added successfully";
                } else {  //not A/L

                    Database::iud("INSERT INTO `notes` (`name`,`file`,`grade_has_subject_id`) VALUES ('" . $Lname . "','" .  $file_name . "','" . $gsId . "')");

                    echo "Lesson added successfully";
                }
            }
        } else {
            echo "Please select a file";
        }
    }
}

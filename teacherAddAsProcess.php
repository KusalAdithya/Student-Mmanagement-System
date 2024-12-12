<?php

session_start();
require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];

    $gsId = $_POST["gsID"];
    $Asname = $_POST["Asname"];
    $Sdate = $_POST["Sdate"];
    $Edate = $_POST["Edate"];

    $Tdate = date("Y-m-d");

    if (empty($Asname)) {
        echo "Please enter a name";
    } else if (empty($Sdate)) {
        echo "Please enter start date";
    } else if($Sdate < $Tdate){
        echo "Please enter valid start date";
    }  else if (empty($Edate)) {
        echo "Please enter end date";
    }else if($Edate < $Sdate){
        echo "Please enter valid end date";
    } else {

        if (isset($_FILES["AddAs"])) {

            $uploadFile = $_FILES["AddAs"];

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

                    Database::iud("INSERT INTO `a/l_assignment` (`name`,`file`,`grade_has_a/l_subjects_id`,`start`,`end`) VALUES ('" . $Asname . "','" .  $file_name . "','" . $gsId . "','" . $Sdate . "','" . $Edate . "')");

                    echo "Asssignment added successfully";
                } else {  //not A/L

                    Database::iud("INSERT INTO `assignment` (`name`,`file`,`grade_has_subject_id`,`start`,`end`) VALUES ('" . $Asname . "','" .  $file_name . "','" . $gsId . "','" . $Sdate . "','" . $Edate . "')");

                    echo "Asssignment added successfully";
                }
            }
        } else {
            echo "Please select a file";
        }
    }
}

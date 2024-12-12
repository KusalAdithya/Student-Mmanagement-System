<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $gradeSelect = $_POST["gradeSelect"];
    $subjectSelect = $_POST["subjectSelect"];
    $AssignmentName = $_POST["AssignmentName"];
    
?>

    <!-- result table -->
    <div style="height: 450px; overflow: scroll;">
        <table class="table table-striped table-hover">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">AD No</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Assignment Name</th>
                    <th scope="col">Marks</th>
                </tr>
            </thead>
            <tbody style="height: fit-content;">
                <?php

                $ASName = "";

                if (!empty($subjectSelect)) {
                    $ASName .= " AND `subject`.`id`='" . $subjectSelect . "' ";
                }
                if (!empty($AssignmentName)) {
                    $ASName .= " AND `assignment`.`name` LIKE '" . $AssignmentName . "%' ";
                }

                $result = Database::search("SELECT `results`.`id`,`results`.`student_s_ad_no`,`assignment`.`name`, `results`.`result`, `subject`.`name` AS `SName` FROM `results` INNER JOIN `student` ON `results`.`student_s_ad_no`=`student`.`s_ad_no` INNER JOIN `assignment` ON `results`.`assignment_id`=`assignment`.`id` INNER JOIN `grade_has_subject` ON `assignment`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id` WHERE `student`.`grade_id`='" . $gradeSelect . "' " . $ASName . "  ORDER BY `results`.`id` ASC ;");

                $in = "0";
                while ($result_rs = $result->fetch_assoc()) {
                    $in = $in + 1;
                ?>
                    <!-- details -->
                    <tr>
                        <th scope="row"><?php echo $in; ?></th>
                        <td><?php echo $result_rs["student_s_ad_no"]; ?></td>
                        <?php
                        $stu = Database::search("SELECT * FROM  `student`  WHERE `student`.`s_ad_no`='" . $result_rs['student_s_ad_no'] . "' ");
                        $stu_rs = $stu->fetch_assoc();
                        ?>
                        <td><?php echo $stu_rs["fname"] . " " . $stu_rs["lname"] ?></td>
                        <td><?php echo $stu_rs["grade_id"]; ?></td>
                        <td><?php echo $result_rs["SName"]; ?></td>
                        <td><?php echo $result_rs["name"]; ?></td>
                        <td><?php echo $result_rs["result"]; ?></td>

                    </tr>

                <?php
                }

                ?>
            </tbody>

        </table>
    </div>


<?php

}
?>
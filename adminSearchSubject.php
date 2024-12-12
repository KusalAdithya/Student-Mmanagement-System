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
                    $ASName .= " AND `a/l_subjects`.`id`='" . $subjectSelect . "' ";
                }
                if (!empty($AssignmentName)) {
                    $ASName .= " AND `a/l_assignment`.`name` LIKE '" . $AssignmentName . "%' ";
                }

                $result = Database::search("SELECT `a/l_results`.`id`,`a/l_results`.`student_s_ad_no`,`a/l_assignment`.`name`, `a/l_results`.`result`, `a/l_subjects`.`name` AS `SName` FROM `a/l_results` INNER JOIN `student` ON `a/l_results`.`student_s_ad_no`=`student`.`s_ad_no` INNER JOIN `a/l_assignment` ON `a/l_results`.`a/l_assignment_id`=`a/l_assignment`.`id` INNER JOIN `grade_has_a/l_subjects` ON `a/l_assignment`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id` WHERE `student`.`grade_id`='" . $gradeSelect . "' " . $ASName . "  ORDER BY `a/l_results`.`id` ASC ;");

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
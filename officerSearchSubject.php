<?php
session_start();

require "connection.php";

if (isset($_SESSION["officer"])) {
    $officer = $_SESSION["officer"];

    $subjectSelect = $_POST["subjectSelect"];
    $AssignmentName = $_POST["AssignmentName"];

?>
    <!-- result table -->
    <div style="height: 450px; overflow: scroll;">
        <table class="table table-striped table-hover">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student AD No</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Assignment Name</th>
                    <th scope="col">Marks</th>
                    <th scope="col">Release</th>
                </tr>
            </thead>
            <tbody style="height: fit-content;">
                <?php
                if (preg_match('/[1][2-3]/', $officer['grade_id'])) {  //get A/L subjects results

                    $ASName = "";
                    if (!empty($subjectSelect)) {
                        $ASName .= " AND `a/l_subjects`.`id`='" . $subjectSelect . "' ";
                    }
                    if (!empty($AssignmentName)) {
                        $ASName .= " AND `a/l_assignment`.`name` LIKE '" . $AssignmentName . "%' ";
                    }


                    $result = Database::search("SELECT `a/l_results`.`id`,`a/l_results`.`student_s_ad_no`,`a/l_assignment`.`name`, `a/l_results`.`result`,`a/l_results`.`status_id` FROM  `a/l_results` INNER JOIN `a/l_assignment` ON `a/l_results`.`a/l_assignment_id`=`a/l_assignment`.`id` INNER JOIN `grade_has_a/l_subjects` ON `a/l_assignment`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id`  WHERE  `grade_has_a/l_subjects`.`grade_id`='" . $officer['grade_id'] . "'  " . $ASName . "  ORDER BY `a/l_results`.`id` ASC ");

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
                            <td><?php echo $result_rs["name"]; ?></td>
                            <td><?php echo $result_rs["result"]; ?></td>
                            <?php
                            if ($result_rs["status_id"] == "2") {  //show & hide buttons
                            ?>  
                                <td><a class="btn btn-info" style="height: fit-content;" id="show<?php echo $result_rs['id']; ?>" onclick="showMarks(<?php echo $result_rs['id']; ?>);">Show</a></td>
                            <?php
                            } else {
                            ?>
                                <td><a class="btn btn-danger" style="height: fit-content;" onclick="showMarks(<?php echo $result_rs['id']; ?>);">Hide</a></td>
                            <?php
                            }
                            ?>

                        </tr>

                    <?php
                    }
                } else {    //get not A/L subjects results

                    $ASName = "";
                    if (!empty($subjectSelect)) {
                        $ASName .= " AND `subject`.`id`='" . $subjectSelect . "' ";
                    }
                    if (!empty($AssignmentName)) {
                        $ASName .= " AND `assignment`.`name` LIKE '" . $AssignmentName . "%' ";
                    }


                    $result = Database::search("SELECT `results`.`id`,`results`.`student_s_ad_no`,`assignment`.`name`, `results`.`result` FROM  `results` INNER JOIN `assignment` ON `results`.`assignment_id`=`assignment`.`id` INNER JOIN `grade_has_subject` ON `assignment`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id`  WHERE  `grade_has_subject`.`grade_id`='" . $officer['grade_id'] . "'  " . $ASName . "  ORDER BY `results`.`id` ASC ");

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
                            <td><?php echo $result_rs["name"]; ?></td>
                            <td><?php echo $result_rs["result"]; ?></td>
                            <?php
                            if ($result_rs["status_id"] == "2") {   //show & hide buttons
                            ?>
                                <td><a class="btn btn-info" style="height: fit-content;" onclick="showMarks(<?php echo $result_rs['id']; ?>);">Show</a></td>
                            <?php
                            } else {
                            ?>
                                <td><a class="btn btn-danger" style="height: fit-content;" onclick="showMarks(<?php echo $result_rs['id']; ?>);">Hide</a></td>
                            <?php
                            }
                            ?>
                        </tr>
                <?php
                    }
                }

                ?>
            </tbody>

        </table>
    </div>
<?php
}
?>
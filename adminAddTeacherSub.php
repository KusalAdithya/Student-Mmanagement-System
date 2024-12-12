<?php
session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $T_id = $_POST["Tid"];
?>

    <div class="row mt-4 mb-4">

        <div class="col-12">
            <!-- title -->
            <div class="row">
                <div class="col-10">
                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold;">Add Subjects to Teacher</h2>
                </div>
                <div class="col-2 text-end">
                    <a class="btn btn-danger" href="adminAddTeacher.php"><i class="bi bi-x-lg"></i></a>
                </div>
            </div>
            <div class="bg-danger bar"></div>
        </div>

        <div class="col-10 mt-4 mx-auto">

            <?php
            $teacher = Database::search("SELECT * FROM  `teacher` WHERE `teacher`.`t_ad_no`='" . $T_id . "'");
            $teacher_rs = $teacher->fetch_assoc();
            ?>

            <div class="row text-center">
                <div class="alert alert-danger col-12 col-lg-4 input1 mx-auto d-none" role="alert" id="alert">
                    <!--error alert -->
                </div>
                <div class="col-md-12 mb-3 ">
                    <label class="form-label h5">Teacher Admission Number : <?php echo $T_id; ?></label>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label h5">Name : <?php echo $teacher_rs["fname"] . " " . $teacher_rs["lname"]; ?></label>
                </div>

                <div class="col-md-12 mb-3 ">
                    <?php
                    $s = Database::search("SELECT * FROM `section` WHERE `section`.`id`='" . $teacher_rs['section_id'] . "' ");
                    $s_r = $s->fetch_assoc()
                    ?>
                    <label class="form-label h5">Section : <?php echo $s_r["name"] ?></label>

                </div>

                <?php
                if ($teacher_rs['section_id'] == "4") { //A/L section
                ?>
                    <div class="col-md-6 mb-3 mx-auto">
                        <label class="form-label">Subject & Grade</label>
                        <select class="form-select" style="border-radius: 10px;" id="selectGrade&Subject" onchange="clearalert();">
                            <option value="0">Select Subject with Grade</option>
                            <?php
                            $sub = Database::search("SELECT `grade_has_a/l_subjects`.`id`,`grade_has_a/l_subjects`.`grade_id`, `a/l_subjects`.`name` FROM  `grade_has_a/l_subjects`  INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id`  ORDER BY `grade_has_a/l_subjects`.`grade_id` ASC ");
                            while ($sub_r = $sub->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $sub_r["id"] ?>">Grade <?php echo $sub_r["grade_id"] ?> - <?php echo $sub_r["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                <?php
                } else {  //not A/L section
                ?>
                    <div class="col-md-6 mb-3 mx-auto">
                        <label class="form-label h5">Subject & Grade</label>
                        <select class="form-select" style="border-radius: 10px;" id="selectGrade&Subject" onchange="clearalert();">
                            <option value="0">Select Subject with Grade</option>
                            <?php
                           $sub = Database::search("SELECT `grade_has_subject`.`id`, `grade_has_subject`.`grade_id`, `subject`.`name` FROM `grade_has_subject` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id`  ORDER BY `grade_has_subject`.`grade_id` ASC ");
                           while ($sub_r = $sub->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $sub_r["id"] ?>">Grade <?php echo $sub_r["grade_id"] ?> - <?php echo $sub_r["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php
                }
                ?>

                <div class="row mt-4 text-center">
                    <div class="col-7 col-md-4 mx-auto d-grid">
                        <button class="btn btn-primary btn2" onclick="adminAddTeacher_G_S(<?php echo $T_id; ?>);">Add Grade & Subject</button>
                    </div>
                </div>

            </div>

        </div>


    </div>
<?php
}
?>
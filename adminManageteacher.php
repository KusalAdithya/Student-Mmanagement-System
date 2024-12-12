<?php

session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

?>
    <div class="row mt-4 mb-4">

        <div class="col-12 mb-3">
            <!--title -->
            <div class="row">
                <div class="col-10">
                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold;">Manage Teachers</h2>
                </div>
                <div class="col-2 text-end">
                    <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>
            <div class="bg-danger bar"></div>
        </div>

        <div class="row">

            <?php

            $teacher = Database::search("SELECT * FROM  `teacher` ORDER BY `teacher`.`t_ad_no` ASC ");

            while ($teacher_rs = $teacher->fetch_assoc()) {
            ?>

                <div class="card1 mt-2 col-5 col-lg-3 mx-auto border border-1" style="width: 17rem; border-radius: 10px;">
                    <div class="card-body text-center">
                        <i class="bi bi-person-lines-fill h1"></i>
                        <h5 class="card-title text-danger fw-bold"><?php echo $teacher_rs["t_ad_no"]; ?></h5>
                        <span class="card-text fw-bold"><?php echo $teacher_rs["fname"] . " " . $teacher_rs["lname"] ?></span><br />
                        <span class="card-text text-primary"><?php echo $teacher_rs["email"]; ?></span><br />

                        <?php    // search section
                        $section = Database::search("SELECT * FROM `section` WHERE `id`='" . $teacher_rs["section_id"] . "' ");
                        $sd = $section->fetch_assoc()
                        ?>
                        <span class="card-text text-secondary">Sction : <?php echo $sd["name"]; ?></span><br />
                        <span class="card-text text-info">Subjects : </span><br />
                        <?php
                        if ($teacher_rs["section_id"] == "4") { //A/L section

                            $sub = Database::search("SELECT `grade_has_a/l_subjects`.`grade_id`, `a/l_subjects`.`name` FROM `teacher_has_a/l_subjects` INNER JOIN `grade_has_a/l_subjects` ON `teacher_has_a/l_subjects`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id` WHERE  `teacher_has_a/l_subjects`.`teacher_t_ad_no`='" . $teacher_rs["t_ad_no"] . "' ORDER BY `grade_has_a/l_subjects`.`grade_id` ASC ");

                            while ($sub_rs = $sub->fetch_assoc()) {
                        ?>
                                <span class="card-text"><?php echo $sub_rs["name"]; ?>- Grade <?php echo $sub_rs["grade_id"]; ?></span><br />
                            <?php
                            }
                        } else { //Not A/L section
                            $sub = Database::search("SELECT `grade_has_subject`.`grade_id`, `subject`.`name` FROM `teacher_has_subject` INNER JOIN `grade_has_subject` ON `teacher_has_subject`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id` WHERE `teacher_has_subject`.`teacher_t_ad_no`='" . $teacher_rs["t_ad_no"] . "'  ORDER BY `grade_has_subject`.`grade_id` ASC ");

                            while ($sub_rs = $sub->fetch_assoc()) {
                            ?>
                                <span class="card-text"><?php echo $sub_rs["name"]; ?>- Grade <?php echo $sub_rs["grade_id"]; ?></span><br />
                            <?php
                            }
                        }

                        if ($teacher_rs["status_id"] == "2") {  //avtive & diactive buttons
                            ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-primary btn2" id="active<?php echo $teacher_rs['t_ad_no']; ?>" onclick="activeTeacher(<?php echo $teacher_rs['t_ad_no']; ?>);">Active</button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-danger btn2" id="active<?php echo $teacher_rs['t_ad_no']; ?>" onclick="activeTeacher(<?php echo $teacher_rs['t_ad_no']; ?>);">Diactive</button>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>

            <?php
            }
            ?>

        </div>

    </div>
<?php
}
?>
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
                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold;">Manage Students</h2>
                </div>
                <div class="col-2 text-end">
                    <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>
            <div class="bg-danger bar"></div>
        </div>

        <div class="row">

            <?php

            $student = Database::search("SELECT * FROM  `student` ORDER BY `student`.`grade_id` ASC ");

            while ($student_rs = $student->fetch_assoc()) {
            ?>

                <div class="card1 mt-2 col-5 col-lg-3 mx-auto border border-1" style="width: 17rem; border-radius: 10px;">
                    <div class="card-body text-center">
                        <i class="bi bi-person-lines-fill h1"></i>
                        <h5 class="card-title text-danger fw-bold"><?php echo $student_rs["s_ad_no"]; ?></h5>
                        <span class="card-text fw-bold"><?php echo $student_rs["fname"] . " " . $student_rs["lname"] ?></span><br />
                        <span class="card-text text-primary"><?php echo $student_rs["email"]; ?></span><br />
                        <span class="card-text" id="gradeUp<?php echo $student_rs['s_ad_no']; ?>">Grade : <?php echo $student_rs["grade_id"]; ?></span><br />

                        <?php    // search section
                        $section = Database::search("SELECT * FROM `section` WHERE `id`='" . $student_rs["section_id"] . "' ");
                        $sd = $section->fetch_assoc()
                        ?>
                        <span class="card-text text-secondary">Sction : <?php echo $sd["name"]; ?></span><br />

                        <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                            <button class="btn btn-success btn2" onclick="addUpGrade(<?php echo $student_rs['s_ad_no']; ?>);">Add up Grade</button>
                        </div>

                        <?php

                        if ($student_rs["status_id"] == "2") {  //avtive & diactive buttons
                        ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-primary btn2" id="active<?php echo $student_rs['s_ad_no']; ?>" onclick="activeStudent(<?php echo $student_rs['s_ad_no']; ?>);">Active</button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-danger btn2" id="active<?php echo $student_rs['s_ad_no']; ?>" onclick="activeStudent(<?php echo $student_rs['s_ad_no']; ?>);">Diactive</button>
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
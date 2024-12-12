<?php

session_start();

require "connection.php";

if (isset($_SESSION["student"])) {
    $student = $_SESSION["student"];

    $sid = $_POST["sid"];
?>

    <div class="row mt-4 mb-4">
        <?php

        if ($_SESSION["student"]["section_id"] == "4") {  // A/L subjects
        ?>
            <div class="col-12">
                <!--subject title -->

                <?php
                $Subjectst = Database::search("SELECT * FROM `a/l_subjects` WHERE `id`='" . $sid . "' ");
                $stn = $Subjectst->fetch_assoc();
                ?>
                <div class="row">
                    <div class="col-10">
                        <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; "><?php echo $stn["name"]; ?></h2>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="bg-primary bar"></div>
            </div>



            <div class="col-11 mt-5 mx-auto">
                <div class="row">
                    <div class="accordion" id="accordionExample">

                        <!-- note table -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Lesson Notes
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Lesson Name</th>
                                                <th scope="col">Download</th>
                                            </tr>
                                        </thead>
                                        <tbody style="height: fit-content;">

                                            <?php

                                            $notes = Database::search("SELECT * FROM `a/l_notes` INNER JOIN `grade_has_a/l_subjects` ON `a/l_notes`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` WHERE `grade_has_a/l_subjects`.`a/l_subjects_id`='" . $sid . "' AND `grade_has_a/l_subjects`.`grade_id`='" . $student["grade_id"] . "' ");
                                            $nr = $notes->num_rows;

                                            $in = "0";
                                            while ($nd = $notes->fetch_assoc()) {
                                                $in = $in + 1;
                                            ?>

                                                <tr>
                                                    <th scope="row"><?php echo $in; ?></th>
                                                    <td><?php echo $nd["name"]; ?></td>
                                                    <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $nd["file"]; ?>" download="<?php echo $nd["file"]; ?>">Download</a></td>
                                                </tr>

                                            <?php
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment table -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Assignments
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Assignment Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Download</th>
                                                <th scope="col">Upload</th>
                                                <th scope="col">Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $assignment = Database::search("SELECT `a/l_assignment`.`id`,`a/l_assignment`.`name`,`a/l_assignment`.`file`,`a/l_assignment`.`start`, `a/l_assignment`.`end` FROM `a/l_assignment` INNER JOIN `grade_has_a/l_subjects` ON `a/l_assignment`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` WHERE `grade_has_a/l_subjects`.`a/l_subjects_id`='" . $sid . "' AND `grade_has_a/l_subjects`.`grade_id`='" . $student["grade_id"] . "' ");
                                            $as = $assignment->num_rows;

                                            $i = "0";
                                            while ($asd = $assignment->fetch_assoc()) {
                                                $i = $i + 1;
                                            ?>

                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $asd["name"]; ?></td>
                                                    <td><?php echo $asd["start"]; ?></td>
                                                    <td><?php echo $asd["end"]; ?></td>
                                                    <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $asd["file"]; ?>" download="<?php echo $asd["file"]; ?>">Download</a></td>
                                                    <?php

                                                    // upload
                                                    $Up = Database::search("SELECT * FROM `a/l_results` WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `a/l_assignment_id`='" . $asd['id'] . "' ");
                                                    $Up_nr = $Up->num_rows;

                                                    $Tdate = date("Y-m-d");
                                                    if ($Up_nr == 1) {   //re upload assigment before end date

                                                        $Up_rs =  $Up->fetch_assoc();
                                                        

                                                        if ($Tdate <= $asd["end"]) {
                                                    ?>
                                                            <td><label class="btn btn-secondary" onclick="Uploadbtn('<?php echo $asd['id']; ?>');">Re Upload</label></td>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <td><label class="btn btn-info">Submitted</label></td>
                                                        <?php
                                                        }
                                                        // marks
                                                        if ($Up_rs["status_id"] == "1") { // wahen Academic Officer's ok students can view results
                                                        ?>
                                                        <td><label class="fs-5 fw-bold text-danger"><?php echo  $Up_rs["result"]; ?></label></td>
    
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td>Pending</td>
                                                        <?php
                                                        }
                                                    } else {  //upload new assignment

                                                        if ($Tdate > $asd["end"]) {
                                                        ?>
                                                            <td><label class="btn btn-danger">Not Submitted</label></td>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <td><label class="btn btn-warning" onclick="Uploadbtn('<?php echo $asd['id']; ?>');">Upload</label></td>

                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- marks -->
                                                        <td>N/A</td>
                                                    <?php

                                                    }
                                                    ?>

                                                </tr>

                                                <!--Assignments Upload modal -->
                                                <div class="modal" tabindex="-1" id="uploadModal<?php echo $asd['id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-primary fw-bold">Upload Assignments</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="alert alert-danger input1 d-none" role="alert" id="alert<?php echo $asd['id']; ?>">
                                                                    <!-- alert -->
                                                                </div>

                                                                <!-- file chooser -->
                                                                <label>Upload your assignment here. (valid .pdf / .zip / .docx files only)</label>
                                                                <input type="file" id="uploadFiles<?php echo $asd['id']; ?>" onclick="clearalertSU('<?php echo $asd['id']; ?>');" />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" onclick="studentUploadSubmit('<?php echo $asd['id']; ?>');">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- modal -->

                                            <?php
                                            }
                                            ?>
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        <?php
        } else {     //not A/L subjects
        ?>

            <div class="col-12">
                <!--subject title -->

                <?php
                $Subjectst1 = Database::search("SELECT * FROM `subject` WHERE `id`='" . $sid . "' ");
                $stn1 = $Subjectst1->fetch_assoc();
                ?>

                <div class="row">
                    <div class="col-10">
                        <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; "><?php echo $stn1["name"]; ?></h2>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="bg-primary bar"></div>
            </div>


            <div class="col-11 mt-5 mx-auto">
                <div class="row">
                    <div class="accordion" id="accordionExample">

                        <!-- note table -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Lesson Notes
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Lesson Name</th>
                                                <th scope="col">Download</th>
                                            </tr>
                                        </thead>
                                        <tbody style="height: fit-content;">

                                            <?php

                                            $notes1 = Database::search("SELECT * FROM `notes` INNER JOIN `grade_has_subject` ON `notes`.`grade_has_subject_id`=`grade_has_subject`.`id` WHERE `grade_has_subject`.`subject_id`='" . $sid . "' AND `grade_has_subject`.`grade_id`='" . $student["grade_id"] . "' ");
                                            $nr1 = $notes1->num_rows;

                                            $in1 = "0";
                                            while ($nd1 = $notes1->fetch_assoc()) {
                                                $in1 = $in1 + 1;
                                            ?>

                                                <tr>
                                                    <th scope="row"><?php echo $in1; ?></th>
                                                    <td><?php echo $nd1["name"]; ?></td>
                                                    <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $nd1["file"]; ?>" download="<?php echo $nd1["file"]; ?>">Download</a></td>
                                                </tr>

                                            <?php
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment table -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Assignments
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Assignment Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Download</th>
                                                <th scope="col">Upload</th>
                                                <th scope="col">Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $assignment1 = Database::search("SELECT `assignment`.`id`,`assignment`.`name`,`assignment`.`file`,`assignment`.`start`, `assignment`.`end` FROM `assignment` INNER JOIN `grade_has_subject` ON `assignment`.`grade_has_subject_id`=`grade_has_subject`.`id` WHERE `grade_has_subject`.`subject_id`='" . $sid . "' AND `grade_has_subject`.`grade_id`='" . $student["grade_id"] . "' ");
                                            $as1 = $assignment1->num_rows;

                                            $i = "0";

                                            while ($asd = $assignment1->fetch_assoc()) {
                                                $i = $i + 1;
                                            ?>

                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $asd["name"]; ?></td>
                                                    <td><?php echo $asd["start"]; ?></td>
                                                    <td><?php echo $asd["end"]; ?></td>
                                                    <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $asd["file"]; ?>" download="<?php echo $asd["file"]; ?>">Download</a></td>

                                                    <?php

                                                    // upload
                                                    $Up = Database::search("SELECT * FROM `results` WHERE `student_s_ad_no`='" . $student['s_ad_no'] . "' AND `assignment_id`='" . $asd['id'] . "' ");
                                                    $Up_nr = $Up->num_rows;

                                                    $Tdate = date("Y-m-d");

                                                    if ($Up_nr == 1) {   //re upload assigment before end date

                                                        $Up_rs =  $Up->fetch_assoc();
                                                        

                                                        if ($Tdate <= $asd["end"]) {
                                                    ?>
                                                            <td><label class="btn btn-secondary" onclick="Uploadbtn('<?php echo $asd['id']; ?>');">Re Upload</label></td>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <td><label class="btn btn-info">Submitted</label></td>
                                                        <?php
                                                        }
                                                        // marks
                                                        if ($Up_rs["status_id"] == "1") { // wahen Academic Officer's ok students can view results
                                                        ?>
                                                             <td><label class="fw-bold text-primary"><?php echo  $Up_rs["result"]; ?></label></td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td>Pending</td>
                                                        <?php
                                                        }
                                                    } else {  //upload new assignment

                                                        if ($Tdate > $asd["end"]) {
                                                        ?>
                                                            <td><label class="btn btn-danger">Not Submitted</label></td>
                                                        <?php

                                                        } else {
                                                        ?>
                                                            <td><label class="btn btn-warning" onclick="Uploadbtn('<?php echo $asd['id']; ?>');">Upload</label></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- marks -->
                                                        <td>N/A</td>
                                                    <?php
                                                    }
                                                    ?>

                                                </tr>

                                                <!--Assignments Upload modal -->
                                                <div class="modal" tabindex="-1" id="uploadModal<?php echo $asd['id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-primary fw-bold">Upload Assignments</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="alert alert-danger input1 d-none" role="alert" id="alert<?php echo $asd['id']; ?>">
                                                                    <!-- alert -->
                                                                </div>

                                                                <!-- file chooser -->
                                                                <label>Upload your assignment here. (valid .pdf / .zip / .docx files only)</label>
                                                                <input type="file" id="uploadFiles<?php echo $asd['id']; ?>" onclick="clearalertSU('<?php echo $asd['id']; ?>');" />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" onclick="studentUploadSubmit('<?php echo $asd['id']; ?>');">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- modal -->

                                            <?php
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        <?php
        }
        ?>

    </div>

<?php
} else {
?>
    <script>
        window.location = "index.php";
    </script>
<?php
}
?>
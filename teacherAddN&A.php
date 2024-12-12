<?php

session_start();

require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];

    $gsid = $_POST["gsid"];

?>

    <div class="row mt-4 mb-4" id="loadanswers">
        <?php

        if ($_SESSION["teacher"]["section_id"] == "4") {  // A/L subjects
        ?>
            <div class="col-12">
                <!--subject title -->

                <?php
                $Subjectst = Database::search("SELECT `a/l_subjects`.`id`,`a/l_subjects`.`name`,`grade_has_a/l_subjects`.`grade_id` FROM `a/l_subjects` INNER JOIN `grade_has_a/l_subjects` ON `a/l_subjects`.`id`=`grade_has_a/l_subjects`.`a/l_subjects_id` WHERE `grade_has_a/l_subjects`.`id`='" . $gsid . "' ");
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
                <div class="barT"></div>
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

                                <div class="row mt-3 mb-3 text-center">
                                    <div class="col-7 col-md-3 mx-auto d-grid">
                                        <button class="btn btn-primary btn2" onclick="addNotes('<?php echo $gsid; ?>');">Add Lesson Notes</button>
                                    </div>
                                </div>

                                <!--add note modal -->
                                <div class="modal" tabindex="-1" id="addNoteModal<?php echo $gsid; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-success fw-bold">Add Note</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="alert alert-danger input1 d-none" role="alert" id="alert">
                                                    <!-- alert -->
                                                </div>
                                                <div class="col-md-12 mb-3 ">
                                                    <label class="form-label">Lesson Name</label>
                                                    <input type="text" class="form-control input2" id="Lname" />
                                                </div>
                                                <!-- file chooser -->
                                                <label>Add lesson note here. (valid .pdf / .zip / .docx files only)</label>
                                                <input type="file" id="addLNote" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="addLessonNote('<?php echo $gsid; ?>');">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->

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

                                            $notes = Database::search("SELECT `a/l_notes`.`id`,`a/l_notes`.`name`,`a/l_notes`.`file` FROM  `a/l_notes` INNER JOIN `grade_has_a/l_subjects` ON `a/l_notes`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN  `teacher_has_a/l_subjects` ON `teacher_has_a/l_subjects`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id`  WHERE `grade_has_a/l_subjects`.`grade_id`='" . $stn['grade_id'] . "' AND `teacher_has_a/l_subjects`.`teacher_t_ad_no`='" . $teacher['t_ad_no'] . "' AND `grade_has_a/l_subjects`.`a/l_subjects_id`='" . $stn["id"] . "' ");

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

                                <div class="row mt-3 mb-3 text-center">
                                    <div class="col-7 col-md-3 mx-auto d-grid">
                                        <button class="btn btn-primary btn2" onclick="addAs('<?php echo $gsid; ?>');">Add Asignment</button>
                                    </div>
                                </div>

                                <!--add assignment modal -->
                                <div class="modal" tabindex="-1" id="addAsModal<?php echo $gsid; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-success fw-bold">Add Assignment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="alert alert-danger input1 d-none" role="alert" id="alertA">
                                                    <!-- alert -->
                                                </div>
                                                <div class="col-md-12 mb-3 ">
                                                    <label class="form-label">Assignment Name</label>
                                                    <input type="text" class="form-control input2" id="Asname" required />
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="date" class="form-control input2" id="Sdate" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">End Date</label>
                                                        <input type="date" class="form-control input2" id="Edate" />
                                                    </div>
                                                </div>
                                                <!-- file chooser -->
                                                <label>Add assignment here. (valid .pdf / .zip / .docx files only)</label>
                                                <input type="file" id="addLAssignment" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="addAssignment('<?php echo $gsid; ?>');">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->

                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Assignment Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Download</th>
                                                <th scope="col">Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $assignment = Database::search("SELECT `a/l_assignment`.`id`,`a/l_assignment`.`name`,`a/l_assignment`.`file`,`a/l_assignment`.`start`, `a/l_assignment`.`end` FROM `a/l_assignment` INNER JOIN `grade_has_a/l_subjects` ON `a/l_assignment`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN  `teacher_has_a/l_subjects` ON `teacher_has_a/l_subjects`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` WHERE `grade_has_a/l_subjects`.`grade_id`='" . $stn['grade_id'] . "' AND `grade_has_a/l_subjects`.`a/l_subjects_id`='" . $stn["id"] . "' AND `teacher_has_a/l_subjects`.`teacher_t_ad_no`='" . $teacher['t_ad_no'] . "' ");
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
                                                    <td><a class="btn btn-info" style="height: fit-content;" onclick="viewAnswers('<?php echo $asd['id']; ?>');">View Answers</a></td>
                                                
                                                </tr>

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
                $Subjectst1 = Database::search("SELECT `subject`.`id`,`subject`.`name`,`grade_has_subject`.`grade_id` FROM `subject` INNER JOIN `grade_has_subject` ON `subject`.`id`=`grade_has_subject`.`subject_id` WHERE `grade_has_subject`.`id`='" . $gsid . "' ");
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
                <div class="barT"></div>
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

                                <div class="row mt-3 mb-3 text-center">
                                    <div class="col-7 col-md-3 mx-auto d-grid">
                                        <button class="btn btn-primary btn2" onclick="addNotes('<?php echo $gsid; ?>');">Add Lesson Notes</button>
                                    </div>
                                </div>

                                <!--add note modal -->
                                <div class="modal" tabindex="-1" id="addNoteModal<?php echo $gsid; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary fw-bold">Add Note</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="alert alert-danger input1 d-none" role="alert" id="alert">
                                                    <!-- alert -->
                                                </div>
                                                <div class="col-md-12 mb-3 ">
                                                    <label class="form-label">Lesson Name</label>
                                                    <input type="text" class="form-control input2" id="Lname" />
                                                </div>
                                                <!-- file chooser -->
                                                <label>Add lesson note here. (valid .pdf / .zip / .docx files only)</label>
                                                <input type="file" id="addLNote" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="addLessonNote('<?php echo $gsid; ?>');">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->

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
                                            $notes1 = Database::search("SELECT `notes`.`id`,`notes`.`name`,`notes`.`file` FROM `notes` INNER JOIN `grade_has_subject` ON `notes`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN  `teacher_has_subject` ON `teacher_has_subject`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id` WHERE `grade_has_subject`.`grade_id`='" . $stn1['grade_id'] . "' AND `teacher_has_subject`.`teacher_t_ad_no`='" . $teacher['t_ad_no'] . "' AND `grade_has_subject`.`subject_id`='" . $stn1["id"] . "' ");

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

                                <div class="row mt-3 mb-3 text-center">
                                    <div class="col-7 col-md-3 mx-auto d-grid">
                                        <button class="btn btn-primary btn2" onclick="addAs('<?php echo $gsid; ?>');">Add Asignment</button>
                                    </div>
                                </div>

                                <!--add assignment modal -->
                                <div class="modal" tabindex="-1" id="addAsModal<?php echo $gsid; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-success fw-bold">Add Assignment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="alert alert-danger input1 d-none" role="alert" id="alertA">
                                                    <!-- alert -->
                                                </div>
                                                <div class="col-md-12 mb-3 ">
                                                    <label class="form-label">Assignment Name</label>
                                                    <input type="text" class="form-control input2" id="Asname" required />
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="date" class="form-control input2" id="Sdate" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">End Date</label>
                                                        <input type="date" class="form-control input2" id="Edate" />
                                                    </div>
                                                </div>
                                                <!-- file chooser -->
                                                <label>Add assignment here. (valid .pdf / .zip / .docx files only)</label>
                                                <input type="file" id="addLAssignment" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" onclick="addAssignment('<?php echo $gsid; ?>');">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->

                                <div class="accordion-body" style="height: 370px; overflow: scroll;">
                                    <table class="table table-striped table-hover">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Assignment Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Download</th>
                                                <th scope="col">Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $assignment1 = Database::search("SELECT `assignment`.`id`,`assignment`.`name`,`assignment`.`file`,`assignment`.`start`, `assignment`.`end` FROM `assignment` INNER JOIN `grade_has_subject` ON `assignment`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN  `teacher_has_subject` ON `teacher_has_subject`.`grade_has_subject_id`=`grade_has_subject`.`id` WHERE `grade_has_subject`.`grade_id`='" . $stn1['grade_id'] . "' AND `grade_has_subject`.`subject_id`='" . $stn1["id"] . "' AND `teacher_has_subject`.`teacher_t_ad_no`='" . $teacher['t_ad_no'] . "' ");

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
                                                    <td><a class="btn btn-info" style="height: fit-content;" onclick="viewAnswers('<?php echo $asd['id']; ?>');">View Answers</a></td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- view answers and add marks -->
                        <!-- ////// -->

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
        window.location = "teacherLogin.php";
    </script>
<?php
}
?>
<?php

session_start();

require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];

    $asid = $_POST["asid"];
?>
    <div id="refershDiv" onload="refreshT(<?php echo  $asid ?>);">
        <?php

        if ($_SESSION["teacher"]["section_id"] == "4") {  // A/L subjects
        ?>

            <div class="col-12">
                <!--assignment title -->

                <?php

                $Aname = Database::search("SELECT * FROM `a/l_assignment`  WHERE `a/l_assignment`.`id`='" . $asid . "' ");
                $Aname_rs = $Aname->fetch_assoc();
                ?>
                <div class="row">
                    <div class="col-10">

                        <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; "><?php echo $Aname_rs["name"]; ?></h2>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="barT"></div>
            </div>

            <div class="col-11 mt-5 mx-auto">
                <div class="row">

                    <!-- answers table -->
                    <div style="height: 500px; overflow: scroll;">
                        <table class="table table-striped table-hover">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student AD No</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Answers</th>
                                    <th scope="col">Marks</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody style="height: fit-content;" id="tbody">
                                <?php

                                $answers = Database::search("SELECT * FROM  `a/l_results`  WHERE `a/l_results`.`a/l_assignment_id`='" . $asid . "' ");

                                $in = "0";
                                while ($answers_rs = $answers->fetch_assoc()) {
                                    $in = $in + 1;
                                ?>
                                    <!-- details -->
                                    <tr>
                                        <th scope="row"><?php echo $in; ?></th>
                                        <td><?php echo $answers_rs["student_s_ad_no"]; ?></td>

                                        <?php
                                        $stu = Database::search("SELECT * FROM  `student`  WHERE `student`.`s_ad_no`='" . $answers_rs['student_s_ad_no'] . "' ");
                                        $stu_rs = $stu->fetch_assoc();
                                        ?>

                                        <td><?php echo $stu_rs["fname"] . " " . $stu_rs["lname"] ?></td>
                                        <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $answers_rs["file"]; ?>" download="<?php echo $answers_rs["file"]; ?>">Download</a></td>
                                        <td><?php echo $answers_rs["result"]; ?></td>

                                        <?php
                                        if ($answers_rs["result"] == "Pending") {
                                        ?>

                                            <td><a class="btn btn-info" style="height: fit-content;" onclick="marksModal(<?php echo $answers_rs['id']; ?>);">Add Marks</a></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td></td>
                                        <?php
                                        }
                                        ?>

                                    </tr>

                                    <!--add marks modal -->
                                    <div class="modal" tabindex="-1" id="addMarksModal<?php echo $answers_rs['id']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-success fw-bold">Add Marks</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert alert-danger input1 d-none" role="alert" id="alertM<?php echo $answers_rs['id']; ?>">
                                                        <!-- alert -->
                                                    </div>
                                                    <div class="col-md-12 mb-3 ">
                                                        <h2 class="d-none" id="asid<?php echo $answers_rs['id']; ?>"><?php echo $answers_rs['a/l_assignment_id']; ?></h2>
                                                        <label class="form-label">Marks</label>
                                                        <input type="number" class="form-control input2" id="addMarks<?php echo $answers_rs['id']; ?>" required min="-1" onclick="clearalertM(<?php echo $answers_rs['id']; ?>)" />
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" onclick="addMarks(<?php echo $answers_rs['id']; ?>);">Submit</button>
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

        <?php
        } else {     //not A/L
        ?>

            <div class="col-12">
                <!--Assignment title -->

                <?php
                $Aname = Database::search("SELECT * FROM `assignment`  WHERE `assignment`.`id`='" . $asid . "' ");
                $Aname_rs = $Aname->fetch_assoc();
                ?>

                <div class="row">
                    <div class="col-10">
                        <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; "><?php echo $Aname_rs["name"]; ?></h2>
                    </div>
                    <div class="col-2 text-end">
                        <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="barT"></div>
            </div>


            <div class="col-11 mt-5 mx-auto">
                <div class="row">

                    <!-- answers table -->
                    <div style="height: 500px; overflow: scroll;">
                        <table class="table table-striped table-hover">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student AD No</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Answers</th>
                                    <th scope="col">Marks</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody style="height: fit-content;" id="tbody">
                                <?php

                                $answers = Database::search("SELECT * FROM  `results`  WHERE `results`.`assignment_id`='" . $asid . "' ");

                                $in = "0";
                                while ($answers_rs = $answers->fetch_assoc()) {
                                    $in = $in + 1;
                                ?>
                                    <!-- details -->
                                    <tr>
                                        <th scope="row"><?php echo $in; ?></th>
                                        <td><?php echo $answers_rs["student_s_ad_no"]; ?></td>

                                        <?php
                                        $stu = Database::search("SELECT * FROM  `student`  WHERE `student`.`s_ad_no`='" . $answers_rs['student_s_ad_no'] . "' ");
                                        $stu_rs = $stu->fetch_assoc();
                                        ?>

                                        <td><?php echo $stu_rs["fname"] . " " . $stu_rs["lname"] ?></td>
                                        <td><a class="btn btn-success" style="height: fit-content;" href="UploadFiles//<?php echo $answers_rs["file"]; ?>" download="<?php echo $answers_rs["file"]; ?>">Download</a></td>
                                        <td><?php echo $answers_rs["result"]; ?></td>

                                        <?php
                                        if ($answers_rs["result"] == "Pending") {
                                        ?>

                                            <td><a class="btn btn-info" style="height: fit-content;" onclick="marksModal(<?php echo $answers_rs['id']; ?>);">Add Marks</a></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td></td>
                                        <?php
                                        }
                                        ?>

                                    </tr>

                                    <!--add marks modal -->
                                    <div class="modal" tabindex="-1" id="addMarksModal<?php echo $answers_rs['id']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-success fw-bold">Add Marks</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert alert-danger input1 d-none" role="alert" id="alertM<?php echo $answers_rs['id']; ?>">
                                                        <!-- alert -->
                                                    </div>
                                                    <div class="col-md-12 mb-3 ">
                                                        <h2 class="d-none" id="asid<?php echo $answers_rs['id']; ?>"><?php echo $answers_rs['assignment_id']; ?></h2>
                                                        <label class="form-label">Marks</label>
                                                        <input type="number" class="form-control input2" id="addMarks<?php echo $answers_rs['id']; ?>" required min="-1" onclick="clearalertM(<?php echo $answers_rs['id']; ?>)" />
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" onclick="addMarks(<?php echo $answers_rs['id']; ?>);">Submit</button>
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
<?php
        }
    } else {
?>
<script>
    window.location = "teacherLogin.php";
</script>
<?php
    }
?>
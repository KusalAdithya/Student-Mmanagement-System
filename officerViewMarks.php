<?php

session_start();

require "connection.php";

if (isset($_SESSION["officer"])) {
    $officer = $_SESSION["officer"];

?>

    <div class="row mt-4 mb-4">

        <div class="col-12">
            <!-- title -->
            <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">Welcome Academic Officer</h2>
            <div class="bg-info bar"></div>
        </div>

        <!-- Dashboard -->
        <div class="col-11 col-md-2 mt-4 mx-auto" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
            <div class="row">

                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                    <button class="btn btn-info btn2" style="background-color: #20c997;" onclick="reloadp();">Student Registration</button>
                </div>
                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                    <button class="btn btn-info btn2">Students Results</button>
                </div>

            </div>
        </div>

        <div class="col-11 col-md-9 mt-4 mx-auto p-4" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
            <div class="row">

                <div class="col-10 col-md-5 mx-auto d-grid mt-3 mb-3">
                    <select class="form-select" id="subjectSelect" onchange="Sname();" style="border-radius: 10px;">
                        <option>Select Subject first</option>

                        <?php
                        if (preg_match('/[1][2-3]/', $officer['grade_id'])) { //get A/L subjects 
                            $S_subject = Database::search("SELECT `a/l_subjects`.`id`,`a/l_subjects`.`name` FROM  `grade_has_a/l_subjects`  INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id`  WHERE `grade_has_a/l_subjects`.`grade_id`='" . $officer['grade_id'] . "' ORDER BY `a/l_subjects`.`name` ASC ");

                            while ($S_rs = $S_subject->fetch_assoc()) {
                        ?>
                                <option value="<?php echo $S_rs['id']; ?>"><?php echo $S_rs['name']; ?></option>
                            <?php
                            }
                        } else {  //get not A/L subjects 
                            $S_subject = Database::search("SELECT `subject`.`id`,`subject`.`name` FROM  `grade_has_subject`  INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id`  WHERE `grade_has_subject`.`grade_id`='" . $officer['grade_id'] . "' ORDER BY `subject`.`name` ASC ");

                            while ($S_rs = $S_subject->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $S_rs['id']; ?>"><?php echo $S_rs['name']; ?></option>
                        <?php
                            }
                        }

                        ?>


                    </select>
                </div>

                <div class="col-10 col-md-6 mx-auto d-grid mt-3 mb-3">
                    <input type="text" class="form-control input2" placeholder="Search by Assignment name" id="searchAssignmentName" onkeyup="Sname();" />
                </div>

                <div id="Tload">
                    <!-- result table -->
                </div>

            </div>
        </div>

    </div>
<?php
}
?>
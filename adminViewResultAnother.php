<?php
session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Admin | Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="img/philip_neri_c_3.png" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
    </head>

    <body class="body1">
        <div class="container-fluid justify-content-center">
            <div class="row align-content-center">

                <div class="col-12 mx-auto mb-3 p-2 fixed-top divAd1">
                    <div class="row mt-1">
                        <!-- logo -->
                        <div class="col-6 col-lg-2 my-auto">
                            <div class="logo1"></div>
                        </div>
                        <!-- logo -->

                        <div class="col-5 col-lg-9 ms-4 ms-lg-5 text-end my-auto">
                            <div class="dropdown">

                                <?php
                                $fn = $_SESSION["admin"]["fname"];
                                $ln = $_SESSION["admin"]["lname"];
                                ?>

                                <span class="btn dropdown-toggle" style="font-family: 'Ubuntu-Light'; " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    <!-- set admin name using session    -->
                                    <b> <?php echo $fn . " " . $ln; ?></b>
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="adminUpdateProfile.php">My Profile</a></li>
                                    <li><label class="dropdown-item" onclick="logOutAd();">Log out</label></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-11 mx-auto mb-3 p-2 px-4 div3" id="load">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <div class="row">
                                <div class="col-10">
                                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">Students Results</h2>
                                </div>
                                <div class="col-2 text-end">
                                    <a class="btn btn-danger" href="adminDashboard.php"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                            <div class="bg-danger bar"></div>

                        </div>

                        <!-- Dashboard -->
                        <div class="col-11 col-md-2 mt-4 mx-auto" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
                            <div class="row">

                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <a class="btn btn-primary btn2" href="adminViewResults.php">A/L Student Results</a>
                                </div>
                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <a class="btn btn-danger btn2">Another Student Results</a>
                                </div>

                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <button class="btn btn-secondary btn2" onclick="reloadp();">clear</button>
                                </div>

                            </div>
                        </div>

                        <div class="col-11 col-md-9 mt-4 mx-auto p-4" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
                            <div class="row">

                                <div class="col-10 col-md-5 mx-auto d-grid mt-3 mb-3">
                                    <select class="form-select" id="gradeSelect" onchange="sortResultAnother();" style="border-radius: 10px;">
                                        <option value="0">Select Grade first</option>
                                        <?php for ($i = 1; $i < 12; $i++) {
                                            ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php
                                        } ?>
                                      
                                    </select>
                                </div>

                                <div class="col-10 col-md-5 mx-auto d-grid mt-3 mb-3">
                                    <select class="form-select" id="subjectSelect" onchange="sortResultAnother();" style="border-radius: 10px;">
                                        <option value="">Select Subject</option>

                                        <?php

                                        $subject = Database::search("SELECT * FROM `subject` ORDER BY `subject`.`name` ASC ");

                                        while ($s_rs = $subject->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $s_rs['id']; ?>"><?php echo $s_rs['name']; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-10 col-md-6 mx-auto d-grid mt-3 mb-3">
                                    <input type="text" class="form-control input2" placeholder="Search by Assignment name" id="searchAssignmentName" onkeyup="sortResultAnother();" />
                                </div>

                                <div id="Tload">
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

                                                $result = Database::search("SELECT `results`.`id`,`results`.`student_s_ad_no`,`assignment`.`name`, `results`.`result`, `subject`.`name` AS `SName` FROM  `results` INNER JOIN `assignment` ON `results`.`assignment_id`=`assignment`.`id` INNER JOIN `grade_has_subject` ON `assignment`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id`  ORDER BY `results`.`id` ASC ");

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

                                </div>



                            </div>
                        </div>

                    </div>
                </div>

                <!-- footer -->
                <?php
                require "footer.php";
                ?>


            </div>
        </div>

        <script src="script.js"></script>
        <script src="bootstrap.bundle.js"></script>

    </body>

    </html>

<?php
} else {
?>
    <script>
        window.location = "adminLogin.php";
    </script>
<?php
}
?>
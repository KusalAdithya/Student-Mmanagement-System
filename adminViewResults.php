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
                                    <a class="btn btn-danger"  href="adminDashboard.php"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                            <div class="bg-danger bar"></div>
                            
                        </div>

                        <!-- Dashboard -->
                        <div class="col-11 col-md-2 mt-4 mx-auto" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
                            <div class="row">

                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <button class="btn btn-danger btn2">A/L Student Results</button>
                                </div>
                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <a class="btn btn-primary btn2" href="adminViewResultAnother.php">Another Student Results</a>
                                </div>

                                <div class="col-6 col-md-11 mx-auto d-grid mt-3 mb-3">
                                    <button class="btn btn-secondary btn2" onclick="reloadp();">clear</button>
                                </div>

                            </div>
                        </div>

                        <div class="col-11 col-md-9 mt-4 mx-auto p-4" style="  background-color: rgb(244, 243, 243); border-radius: 10px;">
                            <div class="row">

                                <div class="col-10 col-md-5 mx-auto d-grid mt-3 mb-3">
                                    <select class="form-select" id="gradeSelect" onchange="sortResult();" style="border-radius: 10px;">
                                        <option value="0">Select Grade first</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>

                                <div class="col-10 col-md-5 mx-auto d-grid mt-3 mb-3">
                                    <select class="form-select" id="subjectSelect" onchange="sortResult();" style="border-radius: 10px;">
                                        <option value="">Select Subject</option>

                                        <?php

                                        $subject = Database::search("SELECT * FROM `a/l_subjects` ORDER BY `a/l_subjects`.`name` ASC ");

                                        while ($s_rs = $subject->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $s_rs['id']; ?>"><?php echo $s_rs['name']; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-10 col-md-6 mx-auto d-grid mt-3 mb-3">
                                    <input type="text" class="form-control input2" placeholder="Search by Assignment name" id="searchAssignmentName" onkeyup="sortResult();" />
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

                                                $result = Database::search("SELECT `a/l_results`.`id`,`a/l_results`.`student_s_ad_no`,`a/l_assignment`.`name`, `a/l_results`.`result`, `a/l_subjects`.`name` AS `SName` FROM  `a/l_results` INNER JOIN `a/l_assignment` ON `a/l_results`.`a/l_assignment_id`=`a/l_assignment`.`id` INNER JOIN `grade_has_a/l_subjects` ON `a/l_assignment`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id`  ORDER BY `a/l_results`.`id` ASC ");

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
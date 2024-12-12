<?php
session_start();

require "connection.php";

if (isset($_SESSION["teacher"])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Teacher | Dashboard</title>
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

                <div class="col-12 mx-auto mb-3 p-2 fixed-top divt1">
                    <div class="row mt-1">
                        <!-- logo -->
                        <div class="col-6 col-lg-2 my-auto">
                            <div class="logo1"></div>
                        </div>
                        <!-- logo -->

                        <div class="col-5 col-lg-9 ms-4 ms-lg-5 text-end my-auto">
                            <div class="dropdown">

                                <?php
                                $fn = $_SESSION["teacher"]["fname"];
                                $ln = $_SESSION["teacher"]["lname"];
                                ?>

                                <span class="btn dropdown-toggle" style="font-family: 'Ubuntu-Light'; " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    <!-- set teacher name using session    -->
                                    <b> <?php echo $fn . " " . $ln; ?></b>
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="teacherUpdateProfile.php">My Profile</a></li>
                                    <li><label class="dropdown-item" onclick="logOutT();">Log out</label></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-10 mx-auto mb-3 p-2 px-4 div3" id="load">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">Welcome Teacher</h2>
                            <div class="barT"></div>
                        </div>

                        <?php
                        $section = $_SESSION["teacher"]["section_id"];

                        if ($section == "4") {  // A/L subjects

                            $Gradecategory = Database::search("SELECT DISTINCT(`grade_has_a/l_subjects`.`grade_id`) FROM `teacher_has_a/l_subjects` INNER JOIN `grade_has_a/l_subjects` ON `teacher_has_a/l_subjects`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id`  WHERE `teacher_has_a/l_subjects`.`teacher_t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

                            while ($G_c_rs = $Gradecategory->fetch_assoc()) {
                        ?>
                                <div class="col-11 mt-4 mx-auto">
                                    <!-- grade view-->
                                    <h3>Grade : <?php echo $G_c_rs["grade_id"]; ?> Subjects</h3>
                                </div>

                                <div class="col-11 mt-2 mx-auto">
                                    <div class="row">
                                        <!-- view subjects -->
                                        <?php
                                        $sub = Database::search("SELECT `a/l_subjects`.`id`, `a/l_subjects`.`name`,`grade_has_a/l_subjects`.`id` AS `gid` FROM `teacher_has_a/l_subjects` INNER JOIN `grade_has_a/l_subjects` ON `teacher_has_a/l_subjects`.`grade_has_a/l_subjects_id`=`grade_has_a/l_subjects`.`id` INNER JOIN `a/l_subjects` ON `grade_has_a/l_subjects`.`a/l_subjects_id`=`a/l_subjects`.`id` WHERE `grade_has_a/l_subjects`.`grade_id`='" . $G_c_rs["grade_id"] . "' AND `teacher_has_a/l_subjects`.`teacher_t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

                                        while ($sub_rs = $sub->fetch_assoc()) {
                                        ?>
                                            <div class="col-5 col-lg-2 mt-2 mx-auto text-center align-content-center div4" onclick="goTo_Add_N_A('<?php echo $sub_rs['gid']; ?>');">
                                                <div class="row mt-4 mb-4">
                                                    <div class="col-12">
                                                        <i class=" bi bi-book h1"></i>
                                                        <h5 class="mt-2 p-2"><?php echo $sub_rs["name"]; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                            <?php
                            }
                        } else {     //not A/L subjects

                            $Gradecategory = Database::search("SELECT DISTINCT(`grade_has_subject`.`grade_id`) FROM `teacher_has_subject` INNER JOIN `grade_has_subject` ON `teacher_has_subject`.`grade_has_subject_id`=`grade_has_subject`.`id` WHERE `teacher_has_subject`.`teacher_t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

                            while ($G_c_rs = $Gradecategory->fetch_assoc()) {
                            ?>
                                <div class="col-11 mt-4 mx-auto">
                                    <!-- grade view-->
                                    <h3>Grade : <?php echo $G_c_rs["grade_id"]; ?> Subjects</h3>
                                </div>

                                <div class="col-11 mt-2 mx-auto">
                                    <div class="row">
                                        <!-- view subjects -->
                                        <?php
                                        $sub = Database::search("SELECT `subject`.`id`,`subject`.`name`, `grade_has_subject`.`id` AS `gs_id` FROM `teacher_has_subject` INNER JOIN `grade_has_subject` ON `teacher_has_subject`.`grade_has_subject_id`=`grade_has_subject`.`id` INNER JOIN `subject` ON `grade_has_subject`.`subject_id`=`subject`.`id` WHERE `grade_has_subject`.`grade_id`='" . $G_c_rs["grade_id"] . "' AND `teacher_has_subject`.`teacher_t_ad_no`='" . $_SESSION["teacher"]["t_ad_no"] . "' ");

                                        while ($sub_rs = $sub->fetch_assoc()) {
                                        ?>
                                            <div class="col-5 col-lg-2 mt-2 mx-auto text-center align-content-center div4" onclick="goTo_Add_N_A('<?php echo $sub_rs['gs_id']; ?>');">
                                                <div class="row mt-4 mb-4">
                                                    <div class="col-12">
                                                        <i class=" bi bi-book h1"></i>
                                                        <h5 class="mt-2 p-2"><?php echo $sub_rs["name"]; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

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
        window.location = "teacherLogin.php";
    </script>
<?php
}
?>
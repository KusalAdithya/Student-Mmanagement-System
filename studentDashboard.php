<?php
session_start();

require "connection.php";

if (isset($_SESSION["student"])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Student | Dashboard</title>
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

                <div class="col-12 mx-auto mb-3 p-2 fixed-top div2">
                    <div class="row mt-1">
                        <!-- logo -->
                        <div class="col-6 col-lg-2 my-auto">
                            <div class="logo1"></div>
                        </div>
                        <!-- logo -->

                        <div class="col-5 col-lg-9 ms-4 ms-lg-5 text-end my-auto">
                            <div class="dropdown">

                                <?php
                                $fn = $_SESSION["student"]["fname"];
                                $ln = $_SESSION["student"]["lname"];
                                ?>

                                <span class="btn dropdown-toggle" style="font-family: 'Ubuntu-Light'; " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    <!-- set student name using session    -->
                                    <b> <?php echo $fn . " " . $ln; ?></b>
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="studentUpdateProfile.php">My Profile</a></li>
                                    <li><label class="dropdown-item" onclick="logOut();">Log out</label></li> 
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-11 mx-auto mb-3 p-2 px-4 div3" id="load">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">Subjects</h2>
                            <div class="bg-primary bar"></div>
                        </div>

                        <?php
                        $grade = $_SESSION["student"]["grade_id"];
                        $section = $_SESSION["student"]["section_id"];

                        if ($section == "4") {  // A/L subjects

                            $category = Database::search("SELECT * FROM `s_category` ");
                            $cn = $category->num_rows;

                            for ($x = 0; $x < $cn; $x++) {
                                $cd = $category->fetch_assoc();
                        ?>
                                <div class="col-11 mt-4 mx-auto">
                                    <!-- category view-->
                                    <h3><?php echo $cd["name"]; ?></h3>
                                </div>

                                <div class="col-11 mt-2 mx-auto">
                                    <div class="row">

                                        <?php
                                        $Subjects = Database::search("SELECT `a/l_subjects`.`id`, `a/l_subjects`.`name` FROM `a/l_subjects` INNER JOIN `grade_has_a/l_subjects` ON `a/l_subjects`.`id`=`grade_has_a/l_subjects`.`a/l_subjects_id` WHERE `grade_has_a/l_subjects`.`grade_id`='" . $grade . "' AND `a/l_subjects`.`s_category_id`='" . $cd["id"] . "' ");
                                        $sr = $Subjects->num_rows;   

                                        for ($y = 0; $y < $sr; $y++) {
                                            $sd = $Subjects->fetch_assoc();
                                        ?>

                                            <!-- view subjects -->
                                            <div class="col-5 col-lg-2 mt-2 mx-auto text-center align-content-center div4" onclick="goTo_N_A('<?php echo $sd['id']; ?>');">
                                                <div class="row mt-4 mb-4">
                                                    <div class="col-12">
                                                        <i class=" bi bi-book h1"></i>
                                                        <h5 class="mt-2  p-2"><?php echo $sd["name"]; ?></h5>
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
                            ?>

                            <div class="col-11 mt-2 mx-auto">
                                <div class="row">

                                    <?php
                                    //view student grade subjects 1-5 | 6-10
                                    $Subjects1 = Database::search("SELECT `subject`.`id`, `subject`.`name` FROM `subject` INNER JOIN `grade_has_subject` ON `subject`.`id`=`grade_has_subject`.`subject_id` WHERE `grade_has_subject`.`grade_id`='" . $grade . "' ");
                                    $sr1 = $Subjects1->num_rows;

                                    for ($y = 0; $y < $sr1; $y++) {
                                        $sd1 = $Subjects1->fetch_assoc();
                                    ?>

                                        <!-- view subjects -->
                                        <div class="col-5 col-lg-2 mt-3 ms-2 mx-auto text-center div4" onclick="goTo_N_A(<?php echo $sd1['id']; ?>);">
                                            <div class="row mt-4 mb-4">
                                                <div class="col-12">
                                                    <i class=" bi bi-book h1"></i>
                                                    <h5 class=" mt-2  p-2"><?php echo $sd1["name"]; ?></h5>
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
        window.location = "index.php";
    </script>
<?php
}
?>
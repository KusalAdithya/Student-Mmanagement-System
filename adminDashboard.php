<?php
session_start();

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

                <div class="col-10 mx-auto mb-3 p-2 px-4 div3" id="load">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">Welcome Admin</h2>
                            <div class="bg-danger bar"></div>
                        </div>

                        <div class="col-11 mt-4 mx-auto">
                            <div class="row">

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="manageOfficer();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                            <i class="bi bi-people-fill h1"></i>
                                            <h5 class="mt-2  p-2">Manage Academic officers</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="manageTeacher();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                            <i class="bi bi-people-fill h1"></i>
                                            <h5 class="mt-2  p-2">Manage Teachers</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="manageStudents();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                            <i class="bi bi-people-fill h1"></i>
                                            <h5 class="mt-2  p-2">Manage Students</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-5">

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="registerOfficer();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                        <i class="bi bi-person-plus-fill h1"></i>
                                            <h5 class="mt-2  p-2">Register Academic officers</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="registerTeacher();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                        <i class="bi bi-person-plus-fill h1"></i>
                                            <h5 class="mt-2  p-2">Register Teachers</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 mt-2 mx-auto text-center align-content-center div4" onclick="studentsResult();">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                            <i class="bi bi-graph-up h1"></i>
                                            <h5 class="mt-2  p-2">Students Results</h5>
                                        </div>
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
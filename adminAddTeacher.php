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

                <div class="col-10 mx-auto mb-3 p-2 px-4 div3" id="load">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <div class="row">
                                <div class="col-10">
                                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold;">Register Teachers</h2>
                                </div>
                                <div class="col-2 text-end">
                                    <a class="btn btn-danger" href="adminDashboard.php"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                            <div class="bg-danger bar"></div>
                        </div>

                        <div class="col-10 mt-4 mx-auto">

                            <div class="row ">
                                <div class="alert alert-danger col-12 col-lg-4 input1 mx-auto d-none" role="alert" id="alert">
                                    <!--error alert -->
                                </div>
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Teacher Admission Number</label>
                                    <input type="number" class="form-control input2" id="TAdN" onclick="clearalert();" min="0" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control input2" id="fname" onclick="clearalert();" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control input2" id="lname" onclick="clearalert();" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Email Address</label>
                                    <input type="text" class="form-control input2" id="email" onclick="clearalert();" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control input2" id="password" onclick="clearalert();" />
                                        <button class="btn btn-outline-secondary input2" type="button" onclick="showPassword();"><i class="bi bi-eye" id="show"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Section</label>
                                    <select class="form-select" style="border-radius: 10px;" id="selectSection" onchange="clearalert();">
                                        <option value="0">Select a Section</option>
                                        <?php
                                        $s = Database::search("SELECT * FROM `section` ");
                                        while ($s_r = $s->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $s_r["id"] ?>"><?php echo $s_r["name"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                            </div>

                            <div class="row mt-4 text-center">
                                <div class="col-10 col-md-5 mx-auto d-grid">
                                    <button class="btn btn-primary btn2" onclick="adminAddTeacher();">Register & Send Vervication Code</button>
                                    <label class="text-black-50">*Add Grade & Subjects will display after registration*</label>
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
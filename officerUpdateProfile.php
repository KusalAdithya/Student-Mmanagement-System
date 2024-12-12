<?php
session_start();

require "connection.php";

if (isset($_SESSION["officer"])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Academic Officer | Dashboard</title>
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

                <div class="col-12 mx-auto mb-3 p-2 fixed-top divAO1">
                    <div class="row mt-1">
                        <!-- logo -->
                        <div class="col-6 col-lg-2 my-auto">
                            <div class="logo1"></div>
                        </div>
                        <!-- logo -->

                        <div class="col-5 col-lg-9 ms-4 ms-lg-5 text-end my-auto">
                            <div class="dropdown">

                                <?php
                                $fn = $_SESSION["officer"]["fname"];
                                $ln = $_SESSION["officer"]["lname"];
                                ?>

                                <span class="btn dropdown-toggle" style="font-family: 'Ubuntu-Light'; " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    <!-- set officer name using session    -->
                                    <b> <?php echo $fn . " " . $ln; ?></b>
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="officerDashboard.php">Dashboard</a></li>
                                    <li><label class="dropdown-item" onclick="logOutAO();">Log out</label></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- breadcrumb -->
                <div class="col-11 mx-auto" style="margin-top: 100px;">
                    <div class="row">

                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="officerDashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>

                    </div>
                </div>


                <div class="col-11 mx-auto mb-3 p-2 px-4 div3" style="margin-top: 0px;">
                    <div class="row mt-4 mb-4">

                        <div class="col-12">
                            <!-- title -->
                            <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold; ">My Profile</h2>
                            <div class="bg-info bar"></div>
                        </div>

                        <!-- details -->
                        <div class="col-9 mx-auto mt-5 mb-4">

                            <div class="row ">
                                <div class="alert alert-danger col-12 col-lg-4 input1 mx-auto d-none" role="alert" id="alert">
                                    <!--error alert -->
                                </div>
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Officer Admission Number</label>
                                    <input type="text" class="form-control input2" readonly value="<?php echo $_SESSION["officer"]["ac_ad_no"]; ?>" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control input2" placeholder="First Name" readonly value="<?php echo $_SESSION["officer"]["fname"]; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control input2" placeholder="Last Name" readonly value="<?php echo $_SESSION["officer"]["lname"]; ?>" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Email Address</label>
                                    <input id="email" type="text" class="form-control input2" value="<?php echo $_SESSION["officer"]["email"]; ?>" onclick="clearalert();" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control input2" id="password" value="<?php echo $_SESSION["officer"]["password"]; ?>" onclick="clearalert();" />
                                        <button class="btn btn-outline-secondary input2" type="button" onclick="showPassword();"><i class="bi bi-eye" id="show"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 mb-3 ">
                                    <label class="form-label">Service for Grade :</label>
                                    <input  type="text" class="form-control input2" readonly value="<?php echo $_SESSION["officer"]["grade_id"]; ?>" />
                                </div>
                                
                            </div>
                    
                            <div class="row mt-5 text-center">
                                <div class="col-7 col-md-3 mx-auto d-grid">
                                    <button class="btn btn-primary btn2" onclick="officerUpdate();">Save</button>
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
        window.location = "officerLogin.php";
    </script>
<?php
}
?>
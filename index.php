<?php
session_start();

if (isset($_SESSION["student"])) {
?>
    <script>
        window.location = "studentDashboard.php";
    </script>
<?php
} else {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Student | Login</title>
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

                <div class="col-11 mt-3 mt-lg-5 mx-auto mb-3 p-2 div1">
                    <div class="row mt-4">
                        <!-- logo -->
                        <div class="col-12 col-lg-6">
                            <div class="logo"></div>
                            <div class="d-none d-md-block img1"></div>
                        </div>
                        <!-- logo -->

                        <!-- login -->
                        <div class="col-12 col-lg-6">
                            <div class="row justify-content-center p-2 my-auto mt-lg-5">
                                <div class="col-11 mt-5">
                                    <p class="text-center title1">Philip Neri College Student Login</p>
                                </div>

                                <!-- check cookies -->
                                <?php
                                $un = "";
                                $pw = "";
                                if (isset($_COOKIE["un"]) && isset($_COOKIE["pw"])) {
                                    $un = $_COOKIE["un"];
                                    $pw = $_COOKIE["pw"];
                                }
                                ?>

                                <div class=" mt-5 mb-4 col-11 col-md-8">

                                    <div class="alert alert-danger input1 d-none" role="alert" id="alert">
                                        <!--error alert -->
                                    </div>

                                    <div class="form-floating">
                                        <input type="email" class="form-control input1" placeholder="name@example.com" value="<?php echo $un ?>" id="username" onclick="clearalert();">
                                        <label class="ms-2" for="username">Username</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-4 mt-1 col-11 col-md-8">
                                    <input type="password" class="form-control input1" placeholder="Password" value="<?php echo $pw ?>" id="password" onclick="clearalert();">
                                    <label class="ms-2" for="password">Password</label>
                                </div>

                                <div class="mb-4  col-11 col-md-8">
                                    <div class="row mt-1">
                                        <!--Remember Me option-->
                                        <div class="col-6">
                                            <div class="form-check ms-1">
                                                <?php
                                                if (isset($_COOKIE["un"]) && isset($_COOKIE["pw"])) {
                                                ?>
                                                    <input class="form-check-input" type="checkbox" value="1" checked id="remember">
                                                <?php
                                                } else {
                                                ?>
                                                    <input class="form-check-input" type="checkbox" value="1" id="remember">
                                                <?php
                                                }
                                                ?>
                                                <label class="form-check-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5 d-grid mt-3 mb-3">
                                    <button class="btn btn-primary btn1" onclick="signIn();">Sign In</button>
                                </div>
                            </div>
                        </div>
                        <!-- login -->

                        <!-- Verification Modal -->
                        <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Enter Verification Code</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="mt-1 mb-1 col-11 mx-auto">

                                            <div class="alert alert-danger input1 d-none" role="alert" id="alert1">
                                                <!-- alert -->
                                            </div>

                                            <div class="form-floating">
                                                <input type="text" class="form-control input1" placeholder="Text" id="vcode" onclick="clearalert1();">
                                                <label class="ms-2" for="vcode">Verification Code</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="studentVerify();">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- payment Modal -->
                        <div class="modal fade" id="paym" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="text-danger">Your trial period expired!</label>
                                        <div class="mt-1 mb-1 col-11 mx-auto">
                                            <div class="alert alert-danger input1 d-none" role="alert" id="alert2">
                                                <!-- alert -->
                                            </div>

                                            <div class="form-floating">
                                                <input type="number" class="form-control input1" value="1000" id="pay" min="0">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="studentPay();">Pay</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- footer -->
                <div class="col-12 d-none d-lg-block fixed-bottom">
                    <p class="text-center">&copy; 2022 PhilipNeriCollege.lk All Rights Reserved</p>
                </div>

            </div>
        </div>

        <script src="script.js"></script>
        <script src="bootstrap.js"></script>
    </body>

    </html>
<?php
}
?>
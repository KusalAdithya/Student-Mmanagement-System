<?php

session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

?>
    <div class="row mt-4 mb-4">

        <div class="col-12 mb-3">
            <!--title -->
            <div class="row">
                <div class="col-10">
                    <h2 style="font-family: 'Ubuntu-Light'; font-weight: bold;">Manage Officers</h2>
                </div>
                <div class="col-2 text-end">
                    <button class="btn btn-danger" onclick="reloadp();"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>
            <div class="bg-danger bar"></div>
        </div>

        <div class="row">

            <?php

            $officer = Database::search("SELECT * FROM  `ac_officer` ORDER BY `ac_officer`.`ac_ad_no` ASC ");

            while ($officer_rs = $officer->fetch_assoc()) {
            ?>

                <div class="card1 mt-2 col-5 col-lg-3 mx-auto border border-1" style="width: 17rem; border-radius: 10px;">
                    <div class="card-body text-center">
                    <i class="bi bi-person-lines-fill h1"></i>
                        <h5 class="card-title text-danger fw-bold"><?php echo $officer_rs["ac_ad_no"]; ?></h5>
                        <span class="card-text fw-bold"><?php echo $officer_rs["fname"] . " " . $officer_rs["lname"] ?></span><br />
                        <span class="card-text text-primary"><?php echo $officer_rs["email"]; ?></span><br />
                        <span class="card-text text-info">Service for : Grade<?php echo $officer_rs["grade_id"]; ?></span><br />
                        <?php

                        if ($officer_rs["status_id"] == "2") {  //avtive & diactive buttons
                        ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-primary btn2" id="active<?php echo $officer_rs['ac_ad_no']; ?>" onclick="activeOfficer(<?php echo $officer_rs['ac_ad_no']; ?>);">Active</button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-9  d-grid mt-3 mb-3 mx-auto">
                                <button class="btn btn-danger btn2" id="active<?php echo $officer_rs['ac_ad_no']; ?>" onclick="activeOfficer(<?php echo $officer_rs['ac_ad_no']; ?>);">Diactive</button>
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

<?php
}
?>
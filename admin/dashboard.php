<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
require_once("../config.php");
$username = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <!-- Boxicons CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/home.css" />
    <link rel="icon" type="image/jpg" href="../images/logo.jpg">
    <title>HOME</title>
    <style type="text/css">
        .col-md-6 {
            flex: 0 0 50%;
            padding-top: 130px;
            padding-left: 300px;
            max-width: 45%;
        }
        /* Ensure the entire card is clickable */
        .card-box a {
            color: inherit; /* Keep text color the same */
            text-decoration: none; /* Remove underline */
            display: block; /* Make the anchor a block element */
        }
        .card-box:hover {
            background-color: #f1f1f1; /* Add a background color on hover */
        }
    </style>
</head>
<body>
    <?php include("home.php")?>

    <div class="row">
        <!-- Start Patients Card -->
        <div class="col-md-6 col-xl-4">
            <div class="widget-rounded-circle card-box">
                <a href="patients.php">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="fab fa-accessible-icon font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <?php
                                    // Code for summing up number of patients
                                    $result ="SELECT count(*) FROM patients";
                                    $stmt = $con->prepare($result);
                                    $stmt->execute();
                                    $stmt->bind_result($patient);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $patient;?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Patients</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Patients Card -->

        <!-- Start Doctors Card -->
        <div class="col-md-6 col-xl-4">
            <div class="widget-rounded-circle card-box">
                <a href="view_doctor.php">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="mdi mdi-flask font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <?php
                                    // Code for summing up number of doctors
                                    $result ="SELECT count(*) FROM doctors";
                                    $stmt = $con->prepare($result);
                                    $stmt->execute();
                                    $stmt->bind_result($assets);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $assets;?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Doctors</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Doctors Card -->

        <!-- Start Nurses Card -->
        <div class="col-md-6 col-xl-4">
            <div class="widget-rounded-circle card-box">
                <a href="view_nurse.php">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="fab fa-accessible-icon font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <?php
                                    // Code for summing up number of nurses
                                    $result ="SELECT count(*) FROM nurses";
                                    $stmt = $con->prepare($result);
                                    $stmt->execute();
                                    $stmt->bind_result($nurses);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $nurses;?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Nurses</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Nurses Card -->

        <!-- Start Clinics Card -->
        <div class="col-md-6 col-xl-4">
            <div class="widget-rounded-circle card-box">
                <a href="clinics.php">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="mdi mdi-flask font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <?php
                                    // Code for summing up number of clinics
                                    $result ="SELECT count(*) FROM clinics";
                                    $stmt = $con->prepare($result);
                                    $stmt->execute();
                                    $stmt->bind_result($clinics);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $clinics;?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Clinics</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Clinics Card -->

    </div> <!-- end row-->
</body>
</html>

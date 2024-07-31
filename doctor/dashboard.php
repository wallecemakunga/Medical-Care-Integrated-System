<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
if (!isset($_SESSION['username'])){
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
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            padding-top: 200px;
            padding-left: 300px;
            max-width: 45%;
        }
        .widget-rounded-circle {
            cursor: pointer; /* Add cursor pointer to indicate clickable */
        }
    </style>
</head>
<body>
    <?php include("home.php")?>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <a href="treatment.php" style="text-decoration: none; color: inherit;">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="fab fa-accessible-icon  font-22 avatar-title text-danger"></i>
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
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <!--End Out Patients-->

        <!--Start InPatients-->
        <div class="col-md-6 col-xl-4">
            <a href="appoint.php" style="text-decoration: none; color: inherit;">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                <i class="mdi mdi-flask font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <?php
                                    // Code for summing up number of appointments for the logged-in doctor
                                    $result ="SELECT count(*) FROM appointment WHERE doctor_id = ?";
                                    $stmt = $con->prepare($result);
                                    $stmt->bind_param("s", $username);
                                    $stmt->execute();
                                    $stmt->bind_result($appointments);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $appointments;?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Appointments</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
    </div> <!-- end row-->

    <!-- Bootstrap Modal for Appointment Notification -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="patientDetails"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/vendor.min.js"></script>
    <script src="../assets/libs/footable/footable.all.min.js"></script>
    <script src="../assets/js/pages/foo-tables.init.js"></script>
    <script src="../assets/js/app.min.js"></script>

    <script>
        // JavaScript function to check appointment date and show Bootstrap modal
        function checkAppointmentDate(appointmentDate, patientName) {
            var currentDate = new Date();
            var apptDate = new Date(appointmentDate);

            // Compare only the date part, ignoring time
            if (currentDate.getFullYear() === apptDate.getFullYear() &&
                currentDate.getMonth() === apptDate.getMonth() &&
                currentDate.getDate() === apptDate.getDate()) {
                // Set modal content dynamically
                var modal = $('#appointmentModal');
                var formattedDetails = 'Appointment Today!<br>Patient: ' + patientName + '<br>Appointment Date: ' + appointmentDate;
                modal.find('.modal-body #patientDetails').html(formattedDetails);

                // Show the modal
                modal.modal('show');
            }
        }

        // Call checkAppointmentDate function for each appointment row
        window.onload = function() {
            <?php
                $q = mysqli_query($con, "SELECT * FROM appointment WHERE doctor_id = '$username' ") or die('Error223');
                while ($row = mysqli_fetch_array($q)) {
                    $appointmentDate = $row['date_of_appointment'];
                    $patientName = $row['Full_Name'];
                    echo "checkAppointmentDate('$appointmentDate', '$patientName');\n";
                }
            ?>
        };
    </script>
</body>
</html>

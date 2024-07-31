<?php 
session_start();
if (!isset($_SESSION['username'])){
	header("location:index.php");
}
require_once("../config.php");

// Get the username of the logged-in user
$username = $_SESSION['username']; 

// Modify the SQL query to join the appointment table with the doctor table
$q = mysqli_query($con, "SELECT a.*, d.Full_Name As dd, c.clinic_name FROM appointment a
    JOIN doctors d ON a.doctor_id = d.doctor_id
    JOIN clinics c ON d.clinic_id = c.clinic_id
") or die('Error223');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Appointments</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/argon.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/libs/footable/footable.core.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/popup_style.css">
    <link rel="icon" type="image/jpeg" href="../images/logo.jpg">
</head>
<body>
	<?php include("home.php")?>
    <div id="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Appointment Details</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 text-sm-center form-inline">
                                            <div class="form-group mr-2" style="display:none">
                                                <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                    <option value="">Show all</option>
                                                    <option value="Discharged">Discharged</option>
                                                    <option value="OutPatients">OutPatients</option>
                                                    <option value="InPatients">InPatients</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-hide="phone">Appointment Number</th>
                                                <th data-hide="phone">Patient Number</th>
                                                <th data-toggle="true">Patient Name</th>
                                                <th data-hide="phone">Patient Phone</th>
                                                <th data-hide="phone">Service</th>
                                                <th data-hide="phone">Appointment Date</th>
                                                <th data-hide="phone">Doctor's Name</th>
                                                <th data-hide="phone">Hospital Name</th>
                                                <th data-hide="phone">Results</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_assoc($q)) {
                                                $appointment_id = $row['appointment_id'];
                                                $patient_id = $row['patient_id'];
                                                $patient_name = $row['Full_Name'];
                                                $patient_phone = $row['phone_number'];
                                                $service = $row['service'];
                                                $appointment_date = $row['date_of_appointment'];
                                                $doctor_name = $row['dd'];
                                                $hospital_name = $row['clinic_name']; // From the joined doctor table
                                                $results = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $appointment_id; ?></td>
                                                <td><?php echo $patient_id; ?></td>
                                                <td><?php echo $patient_name; ?></td>
                                                <td><?php echo $patient_phone; ?></td>
                                                <td><?php echo $service; ?></td>
                                                <td><?php echo $appointment_date; ?></td>
                                                <td><?php echo $doctor_name; ?></td>
                                                <td><?php echo $hospital_name; ?></td>
                                                <td><?php echo $results; ?></td>
                                            </tr>
                                            <?php 
                                                $cnt++;
                                            } 
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="9">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div> <!-- content-page -->
    </div> <!-- wrapper -->
    <script src="../assets/js/vendor.min.js"></script>
    <script src="../assets/libs/footable/footable.all.min.js"></script>
    <script src="../assets/js/pages/foo-tables.init.js"></script>
    <script src="../assets/js/app.min.js"></script>
</body>
</html>

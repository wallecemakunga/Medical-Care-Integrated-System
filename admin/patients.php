<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:index.php");
}
require_once("../config.php");
?>

<!DOCTYPE html>
<html lang="en">
<title>patients</title>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/app.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/argon.min.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/footable/footable.core.min.css">
<link rel="icon" type="text/css" href="../images/logo.jpg">

<body>
    <?php include("home.php")?>

    <div id="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Patient Details</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title"></h4>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 text-sm-center form-inline" >
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
                                                <th data-hide="phone">Patient Number</th>
                                                <th data-toggle="true">Patient Name</th>
                                                
                                                <th data-hide="phone">Patient Address</th>
                                                <th data-hide="phone">Patient Phone</th>
                                                <th data-hide="phone">Patient BirthDate</th>
                                                 <th data-hide="phone">Patient Gender</th>
                                                <th data-hide="phone">Date Added</th>
                                            </tr>
                                        </thead>

                                            <?php
                                            $q=mysqli_query($con,"SELECT * FROM patients  " )or die('Error223');
                                            $cnt=1;
                                            while($row=mysqli_fetch_array($q)){
                                                $n=$row['patient_id'];
                                                $e=$row['Full_Name'];
                                                $t=$row['address'];
                                                $phone=$row['Phone_number'];
                                                $r=$row['dob'];
                                                $Gender=$row['Gender'];
                                                $date=$row['date_added'];

                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $n?></td>
                                                    <td><?php echo $e?></td>
                                                    <td><?php echo $t?></td>
                                                    <td><?php echo $phone?></td>
                                                    <td><?php echo $r?> </td>
                                                    <td><?php echo $Gender?></td>
                                                  
                                                    
                                                    <td><?php
// Assuming $date is fetched from the database
$date = $row['date_added']; // e.g., '2024-07-04 08:32:54.5224'

// Create a DateTime object from the fetched date
$dateTime = new DateTime($date);

// Format the date to 'Y-m-d H:i' to exclude seconds
$formattedDate = $dateTime->format('Y-m-d H:i');

echo $formattedDate; // Outputs: '2024-07-04 08:32'
?></td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div>
                        <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->


        </div>
    </div>

    <!-- Vendor js -->
    <script src="../assets/js/vendor.min.js"></script>

    <!-- Footable js -->
    <script src="../assets/libs/footable/footable.all.min.js"></script>

    <!-- Init js -->
    <script src="../assets/js/pages/foo-tables.init.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.min.js"></script>
</body>
</html>
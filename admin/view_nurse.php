<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:index.php");
}
require_once("../config.php");
?>

<!DOCTYPE html>
<html lang="en">
<title>Nurses</title>
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
                                <h4 class="page-title">Nurse Details</h4>
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
                                                <th data-hide="phone">Registration Number</th>
                                                <th data-toggle="true">Full Name</th>
                                                <th data-hide="phone">Hospital</th>
                                                <th data-hide="phone">Phone Number</th>
                                                 <th data-hide="phone">Gender</th>
                                                 <th data-hide="phone">Role</th>
                                                <th data-hide="phone">Action</th>
                                            </tr>
                                        </thead>

                                          <?php
$query = "
    SELECT n.*, c.clinic_name 
    FROM nurses n
    INNER JOIN clinics c ON n.clinic_id = c.clinic_id
    " or die('Error');
$q = mysqli_query($con, $query) or die('Error223');
$cnt = 1;
while($row = mysqli_fetch_array($q)){
    $n = $row['nurse_id'];
    $e = $row['Full_Name'];
    $t = $row['clinic_name'];
    $phone = $row['Phone_number'];
    $Gender = $row['gender'];
    $r = $row['role'];
?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $n?></td>
                                                    <td><?php echo $e?></td>
                                                    <td><?php echo $t?></td>
                                                    <td><?php echo $phone?></td>
                                                   
                                                    <td><?php echo $Gender?></td>
                                                     <td><?php echo $r?> </td>
                                                  
                                                    
                                                    <td><a href="delete.php?pat_id=<?php echo $n?>&&pat_name=<?php echo $e?>" onclick="return confirm('Are you sure you want to delete Nurse');" class="badge badge-danger"><i class="mdi mdi-eye"></i> Delete</a></td>
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
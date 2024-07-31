 <?php
session_start();
if(!isset($_SESSION["username"])){
  header("Location:index.php");
  exit();
}
?>
 <!DOCTYPE html>
 <html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Book Appointment</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="icon" type="image/jpg" href="../logo.jpg"> 
</head>
<body>

<?php include ("home.php")?>
  <?php
  $pat_id=$_GET['pat_id'];
  $q=mysqli_query($con,"SELECT * FROM patients WHERE patient_id='$pat_id'" );while($row=mysqli_fetch_array($q)){
    $n=$row['patient_id'];
    $e=$row['Full_Name'];
    $t=$row['address'];
    $phone=$row['Phone_number'];
    $r=$row['dob'];
    $Gender=$row['Gender'];
    $passport=$row['passport'];
    $added=$row['date_added'];
    ?>

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">BOOK APPOINTMENT</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Your Name</label>
                  <input type="text" class="form-control" name="fname" placeholder="Enter Patients FullName">
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Patients Email">
                </div>
                <div class="col-md-6">
                  <label for="inputPhone" class="form-label">Phone Number</label>
                  <input type="number" class="form-control" name="phone" placeholder="Phone Number">
                </div>
               <div class="col-12">
                <label class="form-label">Appointment Date</label>
                <input type="date" class="form-control" name="appointment" placeholder="Apartment, studio, or floor" min="<?php echo date('Y-m-d'); ?>">
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form><!-- End Multi Columns Form -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    function getDistrict(regionId) {
    // Clear the district and village dropdowns
    document.getElementById("districtList").innerHTML = '<option value="">Loading...</option>';
        document.getElementById("villageList").innerHTML = '<option value="">Select Section</option>';

        // Make AJAX call to fetch districts based on selected regionId
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "getDistricts.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("districtList").innerHTML = xhr.responseText;
            }
        };
        xhr.send("regionId=" + regionId);
    }

    function getVillages(districtId) {
        // Clear the village dropdown
        document.getElementById("villageList").innerHTML = '<option value="">Loading...</option>';

        // Make AJAX call to fetch villages based on selected districtId
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "getVillages.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("villageList").innerHTML = xhr.responseText;
            }
        };
        xhr.send("districtId=" + districtId);
    }
</script>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
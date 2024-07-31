<?php
session_start();
require_once("../config.php");

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit; // Ensure script stops after redirection
}

// Get the username of the logged-in doctor
$username = $_SESSION['username'];

// Query to fetch clinics (hospitals) associated with the logged-in doctor
$query = mysqli_query($con, "SELECT c.clinic_id, c.clinic_name 
                             FROM clinics c
                             JOIN doctors d ON c.clinic_id = d.clinic_id
                             WHERE d.doctor_id = '$username'");

?>
<!DOCTYPE HTML>
<html>
<head>
  <link href="../assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
  <link rel="stylesheet" href="../assets/css/popup_style.css">
  <link rel="icon" type="image/jpg" href="../assets/logo.jpg">
  <title>Treatment</title>
  <style type="text/css">
    .left-container img {
    filter: sepia(100%);
    width: 100%;
}

.row {
    display: flex;
    margin-top: 130px;
    margin-left: 200px;
    flex-wrap: wrap;
}
  </style>
</head>
<body>
  <?php include("home.php")?>
  <?php
                $pat_id=$_GET['pat_id'];
                $q=mysqli_query($con,"SELECT * FROM patients WHERE patient_id='$pat_id'" );                              
                 while($row=mysqli_fetch_array($q))
                                               {
                                                 $n=$row['patient_id'];
                                                $e=$row['Full_Name'];
                                                $phone=$row['Phone_number'];
                                                $address=$row['address'];
                                                $r=$row['dob'];
                                                $Gender=$row['Gender'];
                                                 

                                            ?>
                                          

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">Fill all fields</h4>
          <!--Add Patient Form-->
          <form method="post">
            <div class="form-row">

              <div class="form-group col-md-6">
                <label for="inputEmail4" class="col-form-label">Patient Name</label>
                <input type="text" required="required" readonly name="fname" value="<?php echo $e;?>" class="form-control">
              </div>

              <div class="form-group col-md-6">
                <label for="inputPassword4" class="col-form-label">Patient id</label>
                <input type="text" readonly name="pat_id" value="<?php echo $n;?>" class="form-control"  required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4" class="col-form-label">Phone Number</label>
                <input type="text" readonly name="phone" value="<?php echo $phone;?>" class="form-control"  required>
              </div>

              <div class="form-group col-md-6">
                <label for="inputEmail4" class="col-form-label">Patient Gender</label>
                <input type="text" readonly name="gender" value="<?php echo $Gender;?>" class="form-control"  required>
              </div>
            </div>

            <hr>
            <div class="form-row">

             <div class="form-group col-md-3">
              <label class="col-form-label">Patient Body Temperature °C</label>
              <input type="text" required="required"  name="bodytemp"class="form-control" id="inputEmail4" placeholder="°C">
            </div>

            <div class="form-group col-md-3">
              <label class="col-form-label">Patient Heart Pulse/Beat BPM</label>
              <input  type="text"  name="heartpulse"  class="form-control"   placeholder="HeartBeats Per Minute" required>
            </div>

            <div class="form-group col-md-3">
              <label class="col-form-label">Patient Respiratory Rate bpm</label>
              <input type="text"  name="resprate"  class="form-control" placeholder="Breathes Per Minute" required>
            </div>

            <div class="form-group col-md-3">
              <label class="col-form-label">Patient Blood Pressure mmHg</label>
              <input type="text"  name="bloodpress"  class="form-control" placeholder="mmHg" required>
            </div>
          </div>


          <hr>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label class="col-form-label">Patient Lab Test</label>
              <textarea class="form-control"  name="lab_records" required placeholder="Lab test description"></textarea>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label class="col-form-label">Patient Prescription</label>
              <textarea class="form-control"  name="Prescription" required placeholder="Fill patients Prescription and Medication"></textarea>
            </div>
          </div>

          <button type="submit" name="treat" class="ladda-button btn btn-success" data-style="expand-right">SUBMIT</button>
        </form>
      </div>
    </div>
  </div>
</div>
 <!-- end row -->
<?php } ?>
</div>

<script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<?php
// Process form data when submitted
if (isset($_POST["treat"])) {
    $fname = $_POST['fname'];
    $pat_id = $_POST['pat_id'];
    $phone = $_POST['phone'];
    //$dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $temp = $_POST['bodytemp'];
    $heartpulse = $_POST['heartpulse'];
    $resprate = $_POST['resprate'];
    $bloodpress = $_POST['bloodpress'];
    $lab_records = $_POST['lab_records'];
    $Prescription = $_POST['Prescription'];

    // Perform validation and database insertion here
    // Example: Inserting into database
   $query = "INSERT INTO medical_records (`fname`, `patient_id`, `phone`, `gender`, `bodytemp`, `heartpulse`, `resprate`, `bloodpress`, `lab_records`, `prescription`) VALUES ('$fname', '$pat_id', '$phone', '$gender', '$temp','$heartpulse', '$resprate', '$bloodpress', '$lab_records', '$Prescription')";

    $query1=mysqli_query($con,$query);
    if ($query1) {
        echo "<div class='popup popup--icon -success js_success-popup popup--visible'>
        <div class='popup__background'></div>
        <div class='popup__content'>
        <h3 class='popup__content__title'>
        Success
        </h3>
        <p>Information successfully Sent.</p>
        <p><a href='treatment.php'><button class='button button--success' data-for='success'>Proceed to Comment</button></a></p>
        </div>
        </div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error adding doctor: " . $stmt->error . "</div>";
    }

}
?>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action Page</title>
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/popup_style.css">
   
  <style>
    .row {
      margin-top: 40px;
    }
  </style>
</head>
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

require_once("../config.php");

if (isset($_GET['pat_id']) && isset($_GET['pat_name']) && isset($_GET['action']) && isset($_GET['app_details'])) {
    $pat_id = $_GET['pat_id'];
    $pat_name = $_GET['pat_name'];
    $action = $_GET['action'];
    $app = $_GET['app_details'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mcis";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Determine status based on action
    $status = '';
    if ($action === 'ACCEPT') {
        $status = 'Accepted';
    } elseif ($action === 'DECLINE'){
        $status = 'Declined';
    }

    // Prepare SQL statement to update status
    $sql = "UPDATE appointment SET status = ? WHERE appointment_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $app);

    // Execute the update
    if ($stmt->execute()) {
        echo "<div class='popup popup--icon -success js_success-popup popup--visible'>
        <div class='popup__background'></div>
        <div class='popup__content'>
        <h3 class='popup__content__title'>
        Success
        </h3>
        <p>Status successfully updated.</p>
        <p><a href='update.php?pat_id=$pat_id&pat_name=$pat_name&status_updated=1'><button class='button button--success' data-for='success'>Proceed to Comment</button></a></p>
        </div>
        </div>";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} elseif (isset($_GET['status_updated']) && $_GET['status_updated'] == 1) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action Page</title>
    <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/popup_style.css">
    <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
    <link rel="stylesheet" type="text/css" href="../style/icon.css">
</head>
<body>
<?php include("home.php") ?>

<div class="row d-flex justify-content-center pt-5">
    <div class="col-md-6">
        <div class="card-header text-white">
            <center>
                <a class="nav-link" style="color:#ffff;">Message</a>
            </center>
        </div>
        <div class="card" style="box-shadow:10px 10px 20px #888888;">
            <div class="card-body text-center">
                <!-- FORM -->
                <form action="update.php" method="POST">
                    <input type="hidden" name="pat_id" value="<?php echo $_GET['pat_id']; ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Appointment date</label>
                            <div class="form-group">
                                <input id='appointmentDate' class="form-control" placeholder="" type='Date' name="dop" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" name="message" placeholder="Enter comments, feedbacks or recommendations"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-info btn-block form-control" name="submit_message" value="CONFIRM">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
* {
  margin: 0px;
  padding: 0px;
}
body {
  margin-right: -270px;
}
.btn-outline-light {
}
.container-fluid {
  margin-left: 235px;
}
.navbar-expand-lg {
  background-color: floralwhite;
}
.card-header {
  background-color: dimgray;
}
body {
  margin-right: -270px;
  background-image: url(../image/3.jpg);
  background-position: cover;
  background-size: ;
}
</style>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Get the current date without any time portion
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Set hours, minutes, seconds, and milliseconds to zero

    // Format the current date to "YYYY-MM-DD" string
    const formattedToday = today.toISOString().split('T')[0];

    // Set the minimum date for the appointment date input
    document.getElementById('appointmentDate').setAttribute('min', formattedToday);
  });
</script>


</body>
</html>

<?php
} elseif (isset($_POST['submit_message']) && isset($_POST['message']) && isset($_POST['dop']) && isset($_POST['pat_id'])) {
    $pat_id = $_POST['pat_id'];
    $message = $_POST['message'];
    $dop=$_POST['dop'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mcis";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to update message
    $sql = "UPDATE appointment SET message = ? ,date_of_appointment = ?  WHERE patient_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $message,$dop, $pat_id);

    // Execute the update
    if ($stmt->execute()) {
        echo "<div class='popup popup--icon -success js_success-popup popup--visible'>
        <div class='popup__background'></div>
        <div class='popup__content'>
        <h3 class='popup__content__title'>
        Success
        </h3>
        <p>Message successfully updated.</p>
        <p><a href='dashboard.php'><button class='button button--success' data-for='success'>Return to home Page</button></a></p>
        </div>
        </div>";
    } else {
        echo "Error updating message: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid parameters provided";
}
?>

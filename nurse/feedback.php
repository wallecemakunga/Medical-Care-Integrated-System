<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

require_once("../config.php");
$pat_id = $_GET['pat_id'];

// Check if $con is defined and is a valid connection
if (!isset($con) || !$con) {
    die("Database connection error");
}

// Prepare the SQL statement to fetch the message
$stmt = $con->prepare("SELECT message FROM appointment WHERE patient_id = ?");
if ($stmt === false) {
    die("MySQL prepare statement error: " . $con->error);
}

$stmt->bind_param("s", $pat_id);
$stmt->execute();
$stmt->bind_result($message);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Response Page</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
    <link rel="stylesheet" type="text/css" href="../assets/css/popup_style.css">
    <style>
        .row {
            margin-top: 70px;
        }
    </style>
</head>
<body>
<?php include("home.php") ?>

<div class="row d-flex justify-content-center pt-5">
    <div class="col-md-6">
        <div class="card-header text-white">
            <center>
                <a class="nav-link" style="color:#ffff;">Response</a>
            </center>
        </div>
        <div class="card" style="box-shadow:10px 10px 20px #888888;">
            <div class="card-body text-center">
                <!-- FORM -->
                <form action="update.php" method="POST">
                    <input type="hidden" name="pat_id" value="<?php echo htmlspecialchars($pat_id); ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" name="message"><?php echo htmlspecialchars($message); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="submit" class="btn btn-info btn-block form-control" name="submit_response" value="Submit">
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
  background-image: url(../image/3.jpg);
  background-position: cover;
  background-size: cover;
}
</style>

</body>
</html>

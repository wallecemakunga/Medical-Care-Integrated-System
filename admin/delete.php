<?php
// Establish database connection
$con = mysqli_connect('localhost', 'root', '', 'mcis');

// Check if pat_id is set
if (isset($_GET['pat_id'])) {
    $delete_id = $_GET['pat_id'];

    // Sanitize input to prevent SQL injection
    $delete_id = mysqli_real_escape_string($con, $delete_id);

    // Initialize a flag to determine where the deletion occurred
    $deletionSuccess = false;
    $deletedFrom = "";

    // Attempt to delete from doctors table
    $sql1 = "DELETE FROM doctors WHERE doctor_id = '$delete_id'";
    $result1 = mysqli_query($con, $sql1);

    if ($result1 && mysqli_affected_rows($con) > 0) {
        $deletionSuccess = true;
        $deletedFrom = "doctor";
    }

    // If not deleted from doctors, try deleting from nurses
    if (!$deletionSuccess) {
        $sql2 = "DELETE FROM nurses WHERE nurse_id = '$delete_id'";
        $result2 = mysqli_query($con, $sql2);

        if ($result2 && mysqli_affected_rows($con) > 0) {
            $deletionSuccess = true;
            $deletedFrom = "nurse";
        }
    }

    // Redirect based on where the record was deleted from
    if ($deletionSuccess) {
        if ($deletedFrom == "doctor") {
            // Redirect to view_doctor.php
            header('Location: view_doctor.php');
            exit();
        } elseif ($deletedFrom == "nurse") {
            // Redirect to view_nurse.php
            header('Location: view_nurse.php');
            exit();
        }
    } else {
        // Handle error if deletion was not successful
        echo "Error deleting record.";
    }
} 
?>

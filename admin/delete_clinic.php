

<?php
// Establish database connection
$con = mysqli_connect('localhost', 'root', '', 'mcis'); // Include your database connection script

if (isset($_GET['pat_id'])) {
    $delete_id = $_GET['pat_id'];

    // Sanitize input to prevent SQL injection
    $delete_id = mysqli_real_escape_string($con, $delete_id);

    // Delete from doctors table
    $sql1 = "DELETE FROM clinics WHERE clinic_id = '$delete_id'";
    $result1 = mysqli_query($con, $sql1);


    // Check if both deletions were successful
    if ($result1) {
        // Redirect to a specific page after successful deletion
        header('Location: clinics.php'); // Replace with your actual redirect page
        exit();
    } else {
        // Handle error if deletion was not successful
        echo "Error deleting record.";
    }
} else {
    // Redirect if no ID is provided
    header('Location:clinics.php'); // Replace with your actual redirect page
    exit();
}
?>

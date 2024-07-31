<!DOCTYPE html>
<html>
<head>
  <link href="../assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
  <link rel="stylesheet" href="../assets/css/popup_style.css">
  <link rel="icon" type="image/jpg" href="../images/logo.jpg">
  <title>Add Nurse</title>
   <script>
 const currentDate = new Date();
const maxDate = new Date(currentDate.getFullYear() - 20, 11, 31);
const input = document.querySelector('input[name="dob"]');

input.max = maxDate.toISOString().split('T')[0];
</script>
</head>


<body>
  <?php include("home.php")?>

  <div class='signup-container'>
    <div class='left-container'>
      <h1><i class="bx bx-hospital font-22 avatar-title text-danger"></i>MCIS</h1>
      <div class='puppy'>
        <img src='../images/back2.jpg'>
      </div>
    </div>

    <form action="nurse.php" method="POST">
      <div class='right-container'>
        <header>
          <h1>Add Nurse!</h1>

          <div class='set'>
            <div class='pets-name'>
              <label for='pets-name'>Name</label>
              <input name="fname" placeholder="Nurse name" type='text' required>
            </div>

            <div class='pets-photo'>
              <input type="file" name="passport" id='pets-upload' > 
              <i class='fas fa-camera-retro'></i>
              <label for='pets-upload'>Upload a photo</label>
            </div>
          </div>

          <div class='set'>
            <div class='pets-breed'>
              <label for='pets-breed'>Phone Number</label>
              <input  name="phone" placeholder="Phone Number" id="phone" type='number' required>
            </div>

            <div class='pets-birthday'>
              <label for='pets-birthday'>Birthday</label>
              <input name="dob" placeholder='MM/DD/YYYY' type='date' required max="<?php echo date('Y') - 20 ?>-12-31">
            </div>
          </div>

          <div class='set'>
            <div class='pets-gender'>
              <label for='pet-gender-female'>Gender</label>
              <div class='radio-container' name="gender">
                <input checked='' id='pet-gender-female' name='gender' type='radio' value='Female' required>
                <label for='pet-gender-female'>Female</label>
                <input id='pet-gender-male' name='gender' type='radio' value='Male' required>
                <label for='pet-gender-male'>Male</label>
              </div>
            </div>

            <div class='set'>
              <div class='pets-gender'>
                <label for='pet-gender-female'>Hospital</label>
                <select onChange="getDistrict(this.value);" class="form-select" name="hospital">
                  <option value="">Select Hospital</option>
                  <?php 
                  $query = mysqli_query($con, "SELECT * FROM clinics");
                  while($row = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $row['clinic_id']; ?>"><?php echo $row['clinic_name']; ?></option>
                    <?php
                  }?>
                </select>
              </div>
            </div>
          </div>
        </header>

        <footer>
          <div class='set'>
            <button input type="submit" name="register" value="REGISTER">REGISTER</button>
          </div>
        </footer>
      </div>
    </form>
  </div>

  <?php
// ADD NURSE
    // Function to generate unique ID
  function generateUniqueId($dob, $gender, $lastFourDigits) {
  // Determine the gender prefix
    $genderPrefix = ($gender == 'Male') ? 'M' : 'F';
    // Combine the first part of the ID with the last four digits
    $uniqueId = $genderPrefix . '-' . str_replace('-', '', $dob) . '-' . $lastFourDigits;
    return $uniqueId;
  }

  // Connect to the database
  $con = mysqli_connect("localhost", "root", "", "mcis");
  if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
  }

// Function to check if email is already taken
function isEmailTaken($con, $fname) {
    $query = "SELECT COUNT(*) AS count FROM nurses WHERE Full_Name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $fname);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}

// Function to validate phone number format
function isPhoneNumberValid($phone) {
    return preg_match("/^[0-9]{10}$/", $phone) === 1; // Assumes a 10-digit phone number
}

// Function to validate password format
function isPasswordValid($password) {
    return preg_match('/^(?=.*[0-9])(?=.*[A-Za-z]).{8,}$/', $password) === 1; // Requires at least one digit, one letter, and be at least 8 characters long
}

// Function to get the last four digits of the last generated ID from the database
function getLastFourDigits($con) {
    $query = "SELECT id_suffix FROM nurses ORDER BY id_suffix DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['id_suffix'] ?? 99; // Default to 0 if no previous IDs exist
}

// Process user registration form
if (isset($_POST["register"])) {
    $fname = $_POST['fname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $passport = $_POST['passport'];
    $hospital = $_POST['hospital'];
    $password = 'Nurse@1234';
    $pass1 = md5($password);
    $role='Nurse';

    // Get the last four digits of the last generated ID
    $lastFourDigits = getLastFourDigits($con);

    // Increment the last four digits
    $lastFourDigits++;

    // Generate unique ID
    $customId = generateUniqueId($dob, $gender, $lastFourDigits);

    if (isEmailTaken($con, $fname)) {
        echo  '<div class="alert alert-danger alert-dismissible fade show" role="alert">
               Username taken .Please choose another name!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } elseif (!isPhoneNumberValid($phone)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Invalid phone number.Please enter ten digits 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';;
    }else {
        // Insert user data into the database

      $sql = "INSERT INTO nurses VALUES ('$customId','$fname', '$dob','$gender','$phone','$hospital','$passport',' $lastFourDigits','$pass1','$role')";
        $query=mysqli_query($con,$sql);
        if ($query) {
           echo "
            <div class='popup popup--icon -success js_success-popup popup--visible'>
                <div class='popup__background'></div>
                <div class='popup__content'>
                    <h3 class='popup__content__title'>
                        Success 
                    </h1>
                    <p>Registration Successfully</p>
                    <p>
                        <a href='view_nurse.php'><button class='button button--success' data-for='success'>Return to Home</button></a>
                    </p>
                </div>
            </div>";
        } else {
            echo" <div class='popup popup--icon -error js_error-popup popup--visible'>
                    <div class='popup__background'></div>
                    <div class='popup__content'>
                        <h3 class='popup__content__title'>
                            Error 
                        </h1>
                        <p>Registration Failed</p>
                        <p>
                            <a href=''><button class='button button--error' data-for='js_error-popup'>Close</button></a>
                        </p>
                    </div>
                </div>";
    }
  }
}
?>
<script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  var phoneInput = document.getElementById('phone');

  // Restrict input to 10 digits
  phoneInput.addEventListener('input', function() {
    if (phoneInput.value.length > 10) {
      phoneInput.value = phoneInput.value.slice(0, 10); // Limit to first 10 digits
    }
  });
});
</script> 
</body>
</html>
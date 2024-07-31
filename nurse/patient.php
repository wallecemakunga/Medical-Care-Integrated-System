<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="../assets/css/popup_style.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
  <link rel="icon" type="image/jpg" href="../images/logo.jpg">
  <title>Registration Form</title>

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
      <h1><i class='fas fa-paw'></i>MCIS</h1>

      <div class='puppy'>
        <img src='dk.jpg'>
      </div>
    </div>

    <form action="patient.php" method="POST">
    <div class='right-container'>
      <header>
        <h1>Registration form!</h1>
        <div class='set'>
          <div class='pets-name'>
            <label for='pets-name'>Name</label>
            <input id='pets-name' name="fname" placeholder="Patients name" type='text' required>
          </div>

          <div class='pets-photo'>
            <input type="file" name="passport" id='pets-upload'> 
            <i class='fas fa-camera-retro'></i>
            <label for='pets-upload'>Upload a photo</label>
          </div>
        </div>

        <div class='set'>
          <div class='pets-breed'>
            <label for='pets-breed'>Phone Number</label>
            <input id='pets-breed' name="phone" placeholder="Phone Number" type='number' required>
          </div>

          <div class='pets-birthday'>
              <label for='pets-birthday'>Birthday</label>
              <input name="dob" placeholder='MM/DD/YYYY' type='date' required max="<?php echo date('Y') - 5 ?>-12-31">
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
          <div class='pets-breed'>
            <label for='pets-breed'>Email</label>
            <input id='pets-breed' name="email" placeholder="Email" type='email' required >
          </div>
        </div>

         <div class='set'>
          
          <div class='pets-breed'>
            <label for='pets-breed'>Address</label>
            <input id='pets-breed' name="address" placeholder="Address" type='text' required>
          </div>
        </div>       
        </header>
        <footer>
          <div class='set'>
             <button input type="submit" name="register" value="REGISTER">REGISTER</button>
          </div>
        </footer>
      </div>
    </div>
</form>

<?php
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
    $query = "SELECT COUNT(*) AS count FROM patients WHERE Full_Name = ?";
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
    $query = "SELECT id_suffix FROM patients ORDER BY id_suffix DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['id_suffix'] ?? 0; // Default to 0 if no previous IDs exist
}

// Process user registration form
if (isset($_POST["register"])) {
    $fname = $_POST['fname'];
    $email=$_POST['email'];
     $phone = $_POST['phone'];
     $dob = $_POST['dob'];
    $address=$_POST['address'];
    $passport = $_POST['passport'];
    $gender = $_POST['gender'];
   

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

              }
     elseif (!isPhoneNumberValid($phone)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Invalid phone number.Please enter ten digits 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';;
    }else {
        // Insert user data into the database
  $sql = "INSERT INTO patients(patient_id,Full_Name,email,Phone_number,dob,address,Gender,passport,id_suffix) VALUES ('$customId','$fname','$email', '$phone','$dob','$address','$gender','$passport','$lastFourDigits')";
      
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
                        <a href='view.php'><button class='button button--success' data-for='success'>Return to Home</button></a>
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

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

  


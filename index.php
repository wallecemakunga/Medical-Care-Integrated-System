<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login Form</title>
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="image/jpg" href="images/logo.jpg">

  <style>
    .bg-img{
      background: url('images/africa.jpg');
      height: 100vh;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body>
  <div class="bg-img">
    <div class="content">
      <header> Login</header>

      <form action="index.php" method="post">
        <div class="field">
          <span class="bx bx-user"></span>
          <input type="text" name="username" required placeholder="Enter User id">
        </div>

        <div class="field space">
          <span class="bx bx-lock"></span>
          <input type="password"  name="password" class="pass-key" required placeholder="Password">
          <span class="show">SHOW</span>
        </div>

        <div class="field space">
          <input type="submit" name="LOGIN" value="LOGIN">
        </div>
        </form>

        <?php
if (isset($_POST["LOGIN"])) {
    $username = $_POST["username"];
    $password =md5($_POST["password"]); 
    
    $con = mysqli_connect("localhost", "root", "", "mcis");
    
    // Check nurses table
    $query_nurse = "SELECT * FROM nurses WHERE nurse_id = '$username' AND password = '$password' LIMIT 1";
    $result_nurse = mysqli_query($con, $query_nurse);
    
    if (mysqli_num_rows($result_nurse) > 0) {
        $nurse = mysqli_fetch_assoc($result_nurse);
        $id = $nurse["nurse_id"];
        $fname = $nurse["Full_Name"];
        $lastFourDigits=$nurse["id_suffix"];
       
        if ($lastFourDigits >= "100") {
           session_start();
         $_SESSION["fname"] = $fname;
          $_SESSION["username"] =  $id;
            header("location: nurse/dashboard.php");
            exit();
        }
    
  }
   // Check doctor table
    $query_doctor = "SELECT * FROM doctors WHERE doctor_id = '$username' AND password = '$password' LIMIT 1";
    $result_doctor = mysqli_query($con, $query_doctor);
    
    if (mysqli_num_rows($result_doctor) > 0) {
        $doctor = mysqli_fetch_assoc($result_doctor);
        $id = $doctor["doctor_id"];
        $fname = $doctor["Full_Name"];
        $lastFourDigits = $doctor["id_suffix"];
        
        if ($lastFourDigits >= '1000') {
            session_start();
            $_SESSION["fname"] = $fname;
            $_SESSION["username"] = $id;
            header("location: doctor/dashboard.php");
            exit();
        }
    }
    
    // Check admin table
    $query_admin = "SELECT * FROM admin WHERE admin_id = '$username' AND password = '$password' LIMIT 1";
    $result_admin = mysqli_query($con, $query_admin);
    
    if (mysqli_num_rows($result_admin) > 0) {
        $admin = mysqli_fetch_assoc($result_admin);
        $id = $admin["admin_id"];
        $fname = $admin["Full_Name"];
        $role = $admin["role"];
        
        if ($role === 'admin') {
            session_start();
            $_SESSION["fname"] = $fname;
            $_SESSION["username"] = $id;
            header("location: admin/dashboard.php");
            exit();
        }
    }
    
    // If no matching user found
    echo "Wrong username or password";

}

?>
</div>
</div>

<script>
  const pass_field = document.querySelector('.pass-key');
  const showBtn = document.querySelector('.show');
  showBtn.addEventListener('click', function(){
    if(pass_field.type === "password"){
      pass_field.type = "text";
      showBtn.textContent = "HIDE";
      showBtn.style.color = "#3498db";    //color for hide
    }else{
      pass_field.type = "password";
      showBtn.textContent = "SHOW";        //color for show
      showBtn.style.color = "#222";
    }
  });
</script>
</body>
</html>
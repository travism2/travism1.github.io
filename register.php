
<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "tourism"; 

try{     
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

        
        $uname = $conn->real_escape_string($_POST['uname']);
        $email = $conn->real_escape_string($_POST['email']);
        $pass = $conn->real_escape_string($_POST['pass']);
        $secure_pass = password_hash($pass, PASSWORD_BCRYPT);
        
        
        $sql = "INSERT INTO register (username, email, password) VALUES ('$uname', '$email', '$secure_pass')";
        
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Registration successful!");</script>';
            // echo "New record created successfully";
        } else {
            // echo "Error: " . $sql . "<br>" . $conn->error;
            throw new Exception("Error: " . $sql . "<br>" . $conn->error);
        }
    }
}
catch(Exception $e){
echo "An error occured :" . $e->getMessage();
}


// $conn->close();

if (isset($conn)) {
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login.css">
  <script src="https://kit.fontawesome.com/b1c3012c92.js" crossorigin="anonymous"></script>
  <title>Login Page</title>
  
</head>

<body>
  <div class="container">
    <div class="box">
      <!------------------------login-------------------------->
      <form action="login.php" method="post" name="log" onsubmit="return logValidation();">

        <div class="box-login" id="login">
          <div class="top-header">
            <h2>Login here</h2>
          </div>
          <div class="input-group">
            <div class="input-field">
              <input type="text" class="input-box" id="logEmail" name="uname" required />
              <label for="logEmail">Username</label>
            </div>
            <div class="input-field">
              <input type="password" class="input-box" id="logPassword" name="pass" required />
              <label for="logPassword">Password</label>
              <div class="eye-area">
                <div class="eye-box" onclick="myLogPassword()">
                  <i class="fa-regular fa-eye" id="eye"></i>
                  <i class="fa-regular fa-eye-slash" id="eye-slash"></i>
                </div>
              </div>
            </div>
            <div class="remember">
              <input type="checkbox" id="formCheck" class="check" />
              <label for="formCheck">Remember Me</label>
            </div>
            <div class="input-field">
              <input type="submit" class="input-submit" value="Sign-In" name="submit" />
            </div>
            <div class="forgot">
              <a href="#">Forgot Password?</a>
            </div>
      </form>
    </div>
  </div>
  <!----------------------------register------------------------->

  <form name="registration" action="register.php" method="post" onsubmit="return formValidation();">

    <div class="box-register" id="register">
      <div class="top-header">
        <h2>Sign Up, Now</h2>
      </div>
      <div class="input-group">
        <div class="input-field">
          <input type="text" class="input-box" id="regUser" name="uname" required />
          <label for="regUser">Username</label>
        </div>
        <div class="input-field">
          <input type="text" class="input-box" id="regEmail" name="email" required />
          <label for="regEmail">Email Address</label>
        </div>
        <div class="input-field">
          <input type="password" class="input-box" id="regPassword" name="pass" required />
          <label for="regPassword">Password</label>
          <div class="eye-area">
            <div class="eye-box" onclick="myRegPassword()">
              <i class="fa-regular fa-eye" id="eye-2"></i>
              <i class="fa-regular fa-eye-slash" id="eye-slash-2"></i>
            </div>
          </div>
        </div>
        <div class="remember">
          <input type="checkbox" id="formCheck-2" class="check" />
          <label for="formCheck-2">Remember Me</label>
        </div>
        <div class="input-field">
          <input type="submit" class="input-submit" value="Sign-In" />
        </div>
      </div>
    </div>
  </form>
  <!------------------------switch-------------------------------->
  <div class="switch">
    <a href="#" class="login" onclick="login()">login</a>
    <a href="#" class="register" onclick="register()">register</a>
    <div class="btn-active" id="btn"></div>
  </div>





  <script>
    var x = document.getElementById('login');
    var y = document.getElementById('register');
    var z = document.getElementById('btn');

    function login() {
      x.style.left = "27px";
      y.style.left = "350px";
      z.style.left = "0px";
    }
    function register() {
      x.style.left = "-350px";
      y.style.left = "25px";
      z.style.left = "150px";
    }

    //view password

    function myLogPassword() {
      var a = document.getElementById('logPassword');
      var b = document.getElementById('eye');
      var c = document.getElementById('eye-slash');

      if (a.type === "password") {
        a.type = "text"
        b.style.opacity = "0";
        c.style.opacity = "1";
      } else {
        a.type = "password"
        b.style.opacity = "1";
        c.style.opacity = "0";
      }
    }
    function myRegPassword() {
      var d = document.getElementById('regPassword');
      var b = document.getElementById('eye-2');
      var c = document.getElementById('eye-slash-2');

      if (d.type === "password") {
        d.type = "text"
        b.style.opacity = "0";
        c.style.opacity = "1";
      } else {
        d.type = "password"
        b.style.opacity = "1";
        c.style.opacity = "0";
      }
    }




    function formValidation() {
      var uid = document.registration.uname;
      var uemail = document.registration.email;
      var upass = document.registration.pass;
      
      

      if (!uid_validation(uid, 5, 15)) {
        return false;
      }

      // Validate password length and format
      if (!upass_validation(upass, 7, 15)) {
        return false;
      }

      // Validate username format (alphabet characters only)
      if (!allLetter(uid)) {
        return false;
      }

      // Validate email format
      if (!ValidateEmail(uemail)) {
        return false;
      }

      // If all validations pass, return true to allow form submission
      return true;
    }

    function uid_validation(uid, mx, my) {
      var uid_len = uid.value.length;
      if (uid_len == 0 || uid_len >= my || uid_len < mx) {
        alert("User Id should not be empty / length be between " + mx + " to " + my);
        uid.focus();
        return false;
      }
      return true;
    }
    function upass_validation(upass, mx, my) {
      var upass_len = upass.value.length;
      if (upass_len == 0 || upass_len >= my || upass_len < mx) {
        alert("Password should not be empty / length be between " + mx + " to " + my);
        upass.focus();
        return false;
      }
      var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*_]).{8,}$/;
      if (!passwordPattern.test(upass.value)) {
        alert("Password must contain at least 8 characters, including at least one number, one uppercase letter, and one special character");
        return false;
      }
      return true;
    }
    function allLetter(uid) {
      var letters = /^[A-Za-z]+$/;
      if (uid.value.match(letters)) {
        return true;
      }
      else {
        alert('Username must have alphabet characters only');
        uid.focus();
        return false;
      }
    }
    function ValidateEmail(uemail) {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (uemail.value.match(mailformat)) {
        return true;
      }
      else {
        alert("You have entered an invalid email address!");
        uemail.focus();
        return false;
      }
    }

    

    function logValidation(){
      var lid = document.log.uname;
      var lpass = document.log.pass;

      if (!lid_validation(lid, 5, 15)) {
        return false;
      }

      // Validate password length and format
      if (!lpass_validation(lpass, 7, 15)) {
        return false;
      }

      // Validate username format (alphabet characters only)
      if (!allLetter(lid)) {
        return false;
      }
      
      return true;
    }

    function lid_validation(lid, mx, my) {
      var lid_len = lid.value.length;
      if (lid_len == 0 || lid_len >= my || lid_len < mx) {
        alert("User Id should not be empty / length be between " + mx + " to " + my);
        lid.focus();
        return false;
      }
      return true;
    }
    function lpass_validation(lpass, mx, my) {
      var lpass_len = lpass.value.length;
      if (lpass_len == 0 || lpass_len >= my || lpass_len < mx) {
        alert("Password should not be empty / length be between " + mx + " to " + my);
        lpass.focus();
        return false;
      }
      var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*_]).{8,}$/;
      if (!passwordPattern.test(lpass.value)) {
        alert("Password must contain at least 8 characters, including at least one number, one uppercase letter, and one special character");
        return false;
      }
      return true;
    }
    function allLetter(lid) {
      var letters = /^[A-Za-z]+$/;
      if (lid.value.match(letters)) {
        return true;
      }
      else {
        alert('Username must have alphabet characters only');
        lid.focus();
        return false;
      }
    }





  </script>
</body>

</html>




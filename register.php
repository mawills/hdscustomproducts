<?php require "php/serverConnect.php" ?>
<html lang="en">
<head>
<title>Create a New Account</title>
<link rel="icon" href="assets/icon.png" type="image/x-icon">
</head>
<body>
  <div id="main">
    <?php
    if(!empty($_POST['email']) && !empty($_POST['password'])) {
      $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
      $email = mysqli_real_escape_string($conn,$_POST['email']);

      $checkUserExists = mysqli_query($conn,"SELECT * FROM users WHERE Email = '".$email."'");

      if(mysqli_num_rows($checkUserExists) == 1) {
        echo "<h1>Error</h1>";
        echo "<p>There is already an account registered with </p>".$email;
      } else {
        $registerquery = mysqli_query($conn,"INSERT INTO users (Email, Password) VALUES('".$email."', '".$password."')");
        if($registerquery) {
          echo "<h1>Success</h1>";
          echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to return.</a>.</p>";
        } else {
          echo "<h1>Error</h1>";
          echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }       
      }
    } else {
      ?>

      <h1>Register</h1>

      <p>Please enter your details below to register.</p>

      <form method="post" action="register.php" name="registerform" id="registerform">
        <fieldset>
        <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <input type="submit" name="register" id="register" value="Register" />
        </fieldset>
      </form>

      <?php
    }
    ?>
  </div>
</body>
</html>
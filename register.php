<?php require "php/serverConnect.php" ?>
<html lang="en">
<head>
<title>Create a New Account</title>
<link rel="icon" href="assets/icon.png" type="image/x-icon">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"><link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://http://192.168.1.118:8080/HDS/index.php#">
          <img id="navbar-logo" src="assets/logo.png">
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">

        <!-- Display login drop-down only if the user is not logged in -->
        <?php
          if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Email'])) {
            ?>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
              <li>
               <div class="row">
                  <div class="col-md-12">
                   <form method="post" class="form" role="form" action="php/checklogin.php" accept-charset="UTF-8" id="login-nav">
                      <div class="form-group">
                       <label  for="email" class="sr-only">Email address</label>
                       <input name="email" type="email" class="form-control" id="email" placeholder="Email address" required>
                      </div>
                      <div class="form-group">
                       <label for="password" class="sr-only">Password</label>
                       <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                       <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="sign-in-button" class="btn btn-primary btn-block">Sign in</button>
                      </div>
                      <div class="checkbox">
                       <label>
                       <input type="checkbox"> keep me logged-in
                       </label>
                      </div>
                   </form>
                  </div>
                  <div class="bottom text-center">
                    Don't have an account? <a href="http://192.168.1.118:8080/HDS/register.php"><b>Create one.</b></a>
                  </div>
               </div>
              </li>
            </ul>
          </li>
          <?php
          }
          else {
            ?>
              <li>
                <a href="http://192.168.1.118:8080/HDS/php/userLogout.php">Logout</a>
              </li>
            <?php
          }

        ?>

        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div id="main">
    <?php
    if(!empty($_POST['email']) && !empty($_POST['password'])) {
      $salt = "Yoshiba the red Shiba Inu";
      $email = stripslashes(mysqli_real_escape_string($conn,$_POST['email']));
      $password = hash('sha256',hash('md5',hash('md5',$salt.$_POST['password']) . hash('sha256',$salt.$_POST['password'])));

      $checkUserExists = mysqli_query($conn,"SELECT * FROM users WHERE Email = '".$email."'");

      ?>
      <div id="registration-wrapper">
        <h1>Register</h1>

        <p>Please enter your details below to register.</p>

        <form method="post" action="register.php" name="registerform" id="registerform">
          <fieldset>
          <label for="email">Email Address:</label>
          <input type="text" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$".{4,255}" required title="-Email must be in the form 'example@example.com'" /><br />

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" pattern=".{4,64}" required title="Password must be from 4 to 64 characters" /><br />

          <input type="submit" name="register" id="register" value="Register" />
          </fieldset>
        </form>
      </div>
      <?php

      if(mysqli_num_rows($checkUserExists) == 1) {
        echo "<p style='color:red;'>There is already an account registered with </p>".$email;
      } else {
        $registerquery = mysqli_query($conn,"INSERT INTO users (Email, Password) VALUES('".$email."', '".$password."')");
        if($registerquery) {
          ?>
          <script>
            $("#registration-wrapper").css("display","none");
          </script>
          <?php
          echo "<h1>Success</h1>";
          echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to return.</a></p>";
        } else {
          echo "<h1>Error</h1>";
          echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }       
      }
    } else {
      ?>
      <div id="registration-wrapper">
        <h1>Register</h1>

        <p>Please enter your details below to register.</p>

        <form method="post" action="register.php" name="registerform" id="registerform">
          <fieldset>
          <label for="email">Email Address:</label>
          <input type="text" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$".{4,255}" required title="-Email must be in the form 'example@example.com'" /><br />

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" pattern=".{4,64}" required title="Password must be from 4 to 64 characters" /><br />

          <input type="submit" name="register" id="register" value="Register" />
          </fieldset>
        </form>
      </div>
      <?php
    }
    ?>
  </div>
</body>
</html>
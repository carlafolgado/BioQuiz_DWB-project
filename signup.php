<?php 
  require 'include.php'; 
  myheader("Sign up");

  if ( isset($_REQUEST['register']) ){
    //Search if the username already exists in the database
    $username = $_REQUEST['inputUsername'];
    $sql_user = "SELECT idUser FROM User WHERE idUser = '$username';";
    $sol_user = mysqli_query($mysqli, $sql_user);
    while ($row_u = mysqli_fetch_assoc($sol_user)) {
      foreach ($row_u as $user){
      } 
    }

    //Search if the email already exist in the database
    $email = $_REQUEST['inputEmail'];
    $sql_email = "SELECT email FROM User WHERE email = '$email';";
    $sol_email = mysqli_query($mysqli, $sql_email);
    while ($row_e = mysqli_fetch_assoc($sol_email)) {
      foreach ($row_e as $email_sol){
      } 
    }

  //Check that the username and email are different to register all
    if ($user == $_REQUEST['inputUsername']) {
    } else { 
      if ($email_sol == $_REQUEST['inputEmail']) {
      } else {
        if ($_REQUEST['inputPassword'] == $_REQUEST['Passwordcheck']) {
          $inputNewuser = "INSERT INTO User (idUser, email, Name, Surname, Password) VALUES (\"".$_REQUEST['inputUsername']."\",\"".$_REQUEST['inputEmail']."\",\"".$_REQUEST['inputName']."\",\"".$_REQUEST['inputSurname']."\",\"".$_REQUEST['inputPassword']."\")";        
          mysqli_query($mysqli, $inputNewuser); 
          header("Location: index.php");
        } else {
        }
      }
    }
  }
?>

<html>
  <body class="text" style="background: linear-gradient(30deg ,white 0%, #6da4d1 45%  55%, white 100%);">
    <div class="container" style="height: 100vh">
      <div class="h-100 row justify-content-center align-items-center text-dark">
        <form class="form-signin col-7 col-md-7" action="signup.php"  >
          <h1 class="h3 mb-3 fw-normal text-center" style="font-size: 30px;">Please enter your personal information</h1>

          <div>
            <label for="inputEmail" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Name </label>
            <input type="text" class="form-control mb-3" name="inputName"  placeholder="Name"  required autofocus>
          </div>
          
          <div>
            <label for="inputEmail" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Surname </label>
            <input type="text" class="form-control mb-3" name="inputSurname" placeholder="Surname" required autofocus>
          </div>       

          <div>
            <label for="inputEmail" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Username </label>
            <?php
              if ( isset($_REQUEST['register']) ){
                if ($user == $_REQUEST['inputUsername']) {
                  echo '<div class="fw-bol text-md-start text-danger" sytle="margin-bottom: 10px;">
                        Username already exists 
                        </div>';
                } else {

                }
              }
            ?>
            <input type="text" class="form-control mb-3" name="inputUsername" placeholder="Username" required autofocus>
          </div>
        

          <div>
            <label for="inputEmail" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Email address </label>
            <?php
              if ( isset($_REQUEST['register']) ){
                if ($email_sol == $_REQUEST['inputEmail']) {
                  echo '<div class="fw-bol text-md-start text-danger" sytle="margin-bottom: 10px;">
                        Email already exists 
                        </div>';
                }
              }
            ?>
            <input type="email" class="form-control mb-3" name="inputEmail" placeholder="Email address" required autofocus>
          </div>
          

          <div>
            <label for="inputPassword" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Password</label>
            <input type="password" class="form-control mb-3" name="inputPassword"  placeholder="Password" required>
          </div>
          
          <div>
            <label for="inputPassword" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Repeat the password</label>
            <?php
              if ( isset($_REQUEST['register']) ){
                if ($_REQUEST['inputPassword'] != $_REQUEST['Passwordcheck']) {  
                  echo '<div class="fw-bol text-md-start text-danger" sytle="margin-bottom: 10px;">
                        Repeated password is wrong
                        </div>'; 
                }
              }
            ?>
            <input type="password" class="form-control mb-3" name="Passwordcheck"  placeholder="Repeat the password" required>
          </div>
          
          <button class="w-100 btn btn-lg btn-secondary mb-2" type="submit" name="register">Register</button>
          <p class="text-center ">
            Already a member? <a class="text-dark" style="font-weight: bold; font-size: 18px" href="index.php" >Log in</a>
          </p>
        </form>
      </div>
    </div>
  </body>
</html>

<?php 
  require 'include.php'; 
  myheader("Log in");

  if ( isset($_REQUEST['login']) ){
    //Search the username in the database
    $username = $_REQUEST['LOGIN'];
    $sql_user = "SELECT idUser FROM User WHERE idUser = '$username';";
    $sol_user = mysqli_query($mysqli, $sql_user);
    while ($row_u = mysqli_fetch_assoc($sol_user)) {
      foreach ($row_u as $user){
      } 
    }

    //Search the email in the database
    $email = $_REQUEST['LOGIN'];
    $sql_email = "SELECT email FROM User WHERE email = '$email';";
    $sol_email = mysqli_query($mysqli, $sql_email);
    while ($row_e = mysqli_fetch_assoc($sol_email)) {
      foreach ($row_e as $email_sol){
      } 
    }
    
    if (($user == $_REQUEST['LOGIN']) or ($email_sol == $_REQUEST['LOGIN'])){
      $user_to_use = $_REQUEST['LOGIN'];

      //Search the password in the database
      $sql_password = "SELECT Password FROM User WHERE idUser = '$user_to_use' OR email = '$user_to_use';";
      $sol_password = mysqli_query($mysqli, $sql_password);
      while ($row_p = mysqli_fetch_assoc($sol_password)) {
        foreach ($row_p as $password){
        }
      } 

      if ($password == $_REQUEST['inputPassword']) {
        //Pick the username in the database
        $sql_userforprofile = "SELECT idUser FROM User WHERE idUser = '$user_to_use' OR email = '$user_to_use';";
        $sol_userforprofile = mysqli_query($mysqli, $sql_userforprofile);
        while ($row_user = mysqli_fetch_assoc($sol_userforprofile)) {
          foreach ($row_user as $USER){
            }
          }
        $_SESSION['User'] = $USER;

        header("Location: profile.php");
      } else {
      }
    } else {
    }
  }
?>

<html>
  <body class="text-center" style="background: linear-gradient(25deg ,white 0%, #6da4d1 45%  , #6da4d1  65%, white 100%);" >
    <div class="container" style="height: 100vh">
      <div class="h-100 row justify-content-center align-items-center text-dark">
        <form class="form-signin col-md-4 col-sm-8" action="index.php">
          <div class="col-md-12  mb-3 text-white" style="font-family: serif; font-weight: bold; font-size: 40px;" > Welcome to BioQuiz   </div>

          <label for="inputEmail" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Email address or Username</label>
            <?php 
              if ( isset($_REQUEST['login']) ){
                if (($user == $_REQUEST['LOGIN']) or ($email_sol == $_REQUEST['LOGIN'])){
                } else {
                  echo '<div class="fw-bol text-md-start text-danger" sytle="margin-bottom: 10px;">
                        The email or username is not registered 
                        </div>';
                }
              }
            ?>
          <input type="text" id="LOGIN" name="LOGIN" class="form-control mb-3" placeholder="Email or Username" required autofocus>

          <label for="inputPassword" class="visually-hidden" style="font-weight: 500; font-size: 20px;">Password</label>
          <?php 
              if ( isset($_REQUEST['login']) ){
                if (($user == $_REQUEST['LOGIN']) or ($email_sol == $_REQUEST['LOGIN'])){
                  if ($password == $_REQUEST['inputPassword']) {
                  } else {
                    echo '<div class="fw-boler text-md-start text-danger" sytle="margin-bottom: 10px;">
                          Incorrect password 
                           </div>';
                  }
                }
              }
            ?>
          <input type="password" id="inputPassword" name="inputPassword" class="form-control mb-3" placeholder="Password" required>

          <button class="w-100 btn btn-lg btn-secondary mb-2" type="submit" name="login">Log in</button>
          <p>
            Not yet a member? <a class="text-dark" style="font-weight: bold; font-size: 18px;" href="signup.php">Sign up</a>
          </p>
        </form>
      </div>
    </div>
  </body>
</html>
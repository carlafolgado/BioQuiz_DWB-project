<?php
  require 'include.php';
  myheader("Profile");
  require 'navbar.php';

  //DATOS DEL USUARIO
  $id = $_SESSION['User'];
  //search in User for name,
  $query = "SELECT * FROM User WHERE idUser='$id';";
  $res = mysqli_query($mysqli, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $email = $row['email'];
    $username = $row['idUser'];
    $name = $row['Name'];
    $surname = $row['Surname'];
    //$profileext = $row['Picture'];
  }

  //CUESTIONARIOS CREADOS
  $query_created = "SELECT Author FROM Questionnaire WHERE Author='$id';";
  $res_created = mysqli_query($mysqli, $query_created);
  $number_created = mysqli_num_rows($res_created);

  //CUESTIONARIOS APROBADOS
  $query_done = "SELECT User_idUser FROM User_questionnaire WHERE User_idUser='$id';";
  $res_done = mysqli_query($mysqli, $query_done);
  $number_done = mysqli_num_rows($res_done);

  $query_pass = "SELECT `Max score` FROM User_questionnaire WHERE User_idUser='$id' AND `Max score` >= 5 ;";
  $res_pass = mysqli_query($mysqli, $query_pass);
  $number_pass = mysqli_num_rows($res_pass);

?>


<body class="bg-light">
  <main class="container">
    <div class="row p-4">
    <div class="col-3 p-4 justify-content-center border-right" style="border-color: #6da4d1 !important;">
        <?php
          $query = "SELECT Picture FROM User WHERE idUser=\"".$_SESSION['User']."\";";
          $res = mysqli_query($mysqli, $query);
          while ($value = mysqli_fetch_assoc($res)) {
            if ($value['Picture'] != NULL) {
              echo '<div class="d-flex justify-content-center"><img class="mx-auto d-block mb-3" style = "object-fit:cover; border-radius: 50%; width: 120px; height: 120px;" src = "'.$value['Picture'].'"></div>';
            } else {
              echo '<div class="d-flex justify-content-center"><img class="mx-auto d-block mb-3" style = "object-fit:cover; border-radius: 50%; width: 120px; height: 120px;" src = "user.png"></div>';
            }
          }
          ?>
        <h4 class="font-italic" style="font-weight: bold;">
          <?php echo $id ?>
        <a class="link text-dark" href="account.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
              <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
              </svg>
        </a>
        </h4>
        <p class="mb-0 text-break">  Name:  <a style="font-weight: 550; font-size: 16px;"><?php echo $name ?></a> <br>
                          Surname:  <a style="font-weight: 550; font-size: 16px;"><?php echo $surname ?></a><br>
                          email: <a style="font-weight: 550; font-size: 16px;"><?php echo $email ?></a><br>
                          Quizzes created:  <a style="font-weight: 550; font-size: 16px;"><?php echo $number_created ?></a> <br>
                          Quizzes passed:  <a style="font-weight: 550; font-size: 16px;"><?php echo $number_pass ?> <?php echo '/' ?> <?php echo $number_done ?></a>
        </p>
        <form action="community.php">
              <button class="btn btn-link-dark p-0" type="submit" name="logout" value="1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
              </button>
            </form>
      </div>
      <div class="col-9">
        <h2 class="p-2 mb-1 rounded text-center">Last questionnaires done</h1>
        <hr class="feature-divider mt-0" style="border-color: #6da4d1">
        <?php
            $q_done = "SELECT Questionnaire_idQuestionnaire FROM User_questionnaire WHERE User_idUser = '$id' ORDER BY Questionnaire_idQuestionnaire DESC LIMIT 2 ;";
            $r_done = mysqli_query($mysqli, $q_done);
            while ($row_done =  mysqli_fetch_assoc($r_done)){
              foreach ($row_done as $idquest_done){
                $qq_done = "SELECT * FROM Questionnaire WHERE idQuestionnaire = '$idquest_done';";
                $r_qdone = mysqli_query($mysqli, $qq_done);
                while ($row = mysqli_fetch_assoc($r_qdone)) {
                  echo '<div class="card flex-row align-items-center w-100 mb-3">
                      <div class="card-body">
                        <h5 class="card-title"><a href="solvequest.php?idQuestionnaire='.$row['idQuestionnaire'].'" class="link text-dark">'.$row['Title'].'</a>
                        </h5>
                        <div class="row">
                          <div class="col-4">
                            <p>Topic: '.$row['Topic_Topic'].'</p>
                          </div>
                          <div class="col-4">
                            <p>Difficulty: '.$row['Pass_rate'].'/5</p>
                          </div>
                        </div>

                        <p class="text-muted text-break">'.$row['Description'].'</p>
                      </div>
                      <div class="col-4 col-md-3 col-xl-2 p-3">';

                  $query = "SELECT Picture FROM User WHERE idUser=\"".$row['Author']."\";";
                  $res2 = mysqli_query($mysqli, $query);
                  while ($value = mysqli_fetch_assoc($res2)) {
                    if ($value['Picture'] == NULL) {
                      echo '<div class="d-flex justify-content-center"><img src="user.png" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    } else {
                      echo '<div class="d-flex justify-content-center"><img src="'.$value['Picture'].'" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    }
                  }

                  echo  '<p style="text-align:center">'.$row['Author'].'</p>
                          </div>
                        </div>';
                }
              }
            }
          ?>


        <h2 class="p-2 mb-1 rounded text-center">Saved questionnaires</h1>
        <hr class="feature-divider mt-0" style="border-color: #6da4d1">
        <?php
            $query_save = "SELECT Questionnaire_idQuestionnaire FROM User_questionnaire WHERE User_idUser = '$id' AND Saved = '1' ORDER BY Questionnaire_idQuestionnaire DESC LIMIT 2;";
            $res_save = mysqli_query($mysqli, $query_save);
            while ($row_save =  mysqli_fetch_assoc($res_save)){
              foreach ($row_save as $idquest_save){
                $q_save = "SELECT * FROM Questionnaire WHERE idQuestionnaire = '$idquest_save';";
                $res_qsave = mysqli_query($mysqli, $q_save);
                while ($row = mysqli_fetch_assoc($res_qsave)) {
                  echo '<div class="card flex-row align-items-center w-100 mb-3">
                      <div class="card-body">
                        <h5 class="card-title"><a href="solvequest.php?idQuestionnaire='.$row['idQuestionnaire'].'" class="link text-dark">'.$row['Title'].'</a>
                        </h5>
                        <div class="row">
                          <div class="col-4">
                            <p>Topic: '.$row['Topic_Topic'].'</p>
                          </div>
                          <div class="col-4">
                            <p>Difficulty: '.$row['Pass_rate'].'/5</p>
                          </div>
                        </div>

                        <p class="text-muted text-break">'.$row['Description'].'</p>
                      </div>
                      <div class="col-4 col-md-3 col-xl-2 p-3">';

                  $query = "SELECT Picture FROM User WHERE idUser=\"".$row['Author']."\";";
                  $res2 = mysqli_query($mysqli, $query);
                  while ($value = mysqli_fetch_assoc($res2)) {
                    if ($value['Picture'] == NULL) {
                      echo '<div class="d-flex justify-content-center"><img src="user.png" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    } else {
                      echo '<div class="d-flex justify-content-center"><img src="'.$value['Picture'].'" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    }
                  }

                  echo  '<p style="text-align:center">'.$row['Author'].'</p>
                          </div>
                        </div>';
                }
              }
            }
          ?>


        <h2 class="p-2 mb-1 rounded text-center">Questionnaires created</h1>
        <hr class="feature-divider mt-0" style="border-color: #6da4d1">
        <?php
            $query = "SELECT * FROM Questionnaire WHERE Author = '$id' ORDER BY idQuestionnaire DESC LIMIT 2;";
            $res = mysqli_query($mysqli, $query);
            while ($row = mysqli_fetch_assoc($res)) {
              echo '<div class="card flex-row align-items-center w-100 mb-3">
                      <div class="card-body">
                        <h5 class="card-title"><a href="solvequest.php?idQuestionnaire='.$row['idQuestionnaire'].'" class="link text-dark">'.$row['Title'].'</a>
                        </h5>
                        <div class="row">
                          <div class="col-4">
                            <p>Topic: '.$row['Topic_Topic'].'</p>
                          </div>
                          <div class="col-4">
                            <p>Difficulty: '.$row['Pass_rate'].'/5</p>
                          </div>

                        </div>

                        <p class="text-muted text-break">'.$row['Description'].'</p>
                      </div>
                      <div class="col-4 col-md-3 col-xl-2 p-3">';

                  $query = "SELECT Picture FROM User WHERE idUser=\"".$row['Author']."\";";
                  $res2 = mysqli_query($mysqli, $query);
                  while ($value = mysqli_fetch_assoc($res2)) {
                    if ($value['Picture'] == NULL) {
                      echo '<div class="d-flex justify-content-center"><img src="user.png" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    } else {
                      echo '<div class="d-flex justify-content-center"><img src="'.$value['Picture'].'" alt="" class="card-img-top mb-3" style="object-fit:cover; border-radius: 50%; width: 80px; height: 80px;"></div>';
                    }
                  }

                  echo  '<p style="text-align:center">'.$row['Author'].'</p>
                          </div>
                        </div>';
            }
        ?>

      </div>
    </div>
  </main>
</body>

<?php myfooter(); ?>

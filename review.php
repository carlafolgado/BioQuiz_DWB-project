<?php
  require 'include.php';
  myheader('Solve questionnaire');
  require 'navbar.php';
  $query = "SELECT * FROM Question WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
  $questions = mysqli_query($mysqli, $query);
  if ($_REQUEST['submit'] == 1) {

    if (!isset($_REQUEST['answer'])) {
      $_REQUEST['answer'] = [];
    }

    $score = 0;
    $incorrect = [];
    $correct = [];

    $query = "SELECT * FROM Question WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
    $questions = mysqli_query($mysqli, $query);
    
    while ($question = mysqli_fetch_assoc($questions)) {
      $idQuestion = $question['idQuestion'];
      
      $query = "SELECT * FROM Answer WHERE Question_idQuestion=".$idQuestion.";";
      $answers = mysqli_query($mysqli, $query);
      
      while ($answer = mysqli_fetch_assoc($answers)) {
        $idAnswer = $answer['idAnswer'];
        
        if (($answer['Correct'] == 0) and (isset($_REQUEST['answer'][$idAnswer]))) {          
          $correct[$idQuestion][$idAnswer] = 0;                  
        } else if ( ($answer['Correct'] != 0) and (!isset($_REQUEST['answer'][$idAnswer])) ) {          
          $correct[$idQuestion][$idAnswer] = 1;          
        } else if ( ($answer['Correct'] != 0) and (isset($_REQUEST['answer'][$idAnswer]))) {
          $correct[$idQuestion][$idAnswer] = 2;          
        }
      }

      if ( (!in_array(0, $correct[$idQuestion])) and (!in_array(1, $correct[$idQuestion])) ) {
        $score += 1;
      }

    }
    $total_questions = mysqli_num_rows($questions);
    $query = "SELECT * FROM Question WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
    $questions = mysqli_query($mysqli, $query);
  }

  if ($_REQUEST['save']){
    $query = "UPDATE User_questionnaire SET Saved=1 WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire']." AND User_idUser=\"".$_SESSION['User']."\";";
    mysqli_query($mysqli, $query);
    header("Location: profile.php");
  }

?>

<script>
  var incorrect = <?php echo json_encode($incorrect); ?>;
  var correct = <?php echo json_encode($correct); ?>;
</script> 


<body class="bg-light">
  <main class="container">
    <div class="d-flex flex-row flex-fill">
      <?php
        $n_quest = 1;
        $questionids = array();
        if (isset($questions)) {
          while ($question = mysqli_fetch_assoc($questions)) {

            echo '<div id="question'.$n_quest.'" class="question w-100">
            <h2 class="p-2 w-100">Question '.$n_quest.'</h2>
            <hr class="feature-divider mt-0" style="border-color: #6da4d1">
            <div class="card">
                    <b><p class="fst-italic p-3 w-100 mb-0">'.$question['Question'].'</p></b>
                      <ul class="list-group list-group-flush">';
            
            $query = "SELECT * FROM Answer WHERE Question_idQuestion=".$question['idQuestion'].";";
            $answers = mysqli_query($mysqli, $query);

            array_push($questionids, $question['idQuestion']);


            while ($answer = mysqli_fetch_assoc($answers)) {
              $idAnswer = $answer['idAnswer'];

              echo  '<li class="list-group-item" id="answer'.$idAnswer.'">
                        <div class="form-check">';
              if ($_REQUEST['answer'][$idAnswer] == "on") {
                echo '<input type="checkbox" class="form-check-input" value="" id="'.$answer['idAnswer'].'" name="answer['.$answer['idAnswer'].']" checked disabled>';
              } else {
                echo '<input type="checkbox" class="form-check-input" id="'.$answer['idAnswer'].'" name="answer['.$answer['idAnswer'].']" value="'.$_REQUEST['answer']['idAnswer'].'" disabled>';
              }
              echo '<label for="answer['.$answer['idAnswer'].']">'.$answer['Answer'].'</label>
                        </div>
                      </li>';
              $n_answer += 1; 
            }
            echo '</ul></div></div>';
            $n_quest += 1;
          }
        }
        ?>
      <div class="col-4">
        <h2 class="mt-3">Questions</h2>
        <div class="d-flex flex-wrap justify-content-start text-center">
          <?php foreach ($questionids as $x => $id) : ?>
            <button id="button<?= $id ?>" class="question-box col-4 col-xl-2 border p-3 m-1" name="<?= $x+1 ?>"><?php echo $x+1 ?></button>
          <?php endforeach ?>
      </div>
      </div>
    </div>
    </div>

     <div class="d-grid gap-2">
        <button id="prevquestion" class="btn btn-primary blue rounded mt-3" type="button">Previous question</button>
        <button id="nextquestion" class="btn btn-primary blue rounded mt-3" type="button">Next question</button>
      </div>    
      <?php 
        $mark = number_format($score/$total_questions*10, 2);
        echo '<h4 class="mt-3">'.$score.' out of '.$total_questions.' questions right. Final mark: '.$mark.'</h4>';
        $query = "SELECT * FROM User_questionnaire WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire']." AND User_idUser=\"".$_SESSION['User']."\";";
        $exists = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($exists) > 0) {
          while ($row = mysqli_fetch_assoc($exists)) {
            if ($row['Max score'] < $mark) {
              $query = "UPDATE User_questionnaire  SET `Max score` = ".$mark." WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire']." AND User_idUser=\"".$_SESSION['User']."\";";
              mysqli_query($mysqli, $query);
            }
          }
        } else {
          $query = "INSERT INTO User_questionnaire (`Max score`, Questionnaire_idQuestionnaire, User_idUser) VALUES (".$mark.", ".$_SESSION['idQuestionnaire'].", \"".$_SESSION['User']."\");";
          mysqli_query($mysqli, $query);
        }
    ?>
    <div class="d-grid gap-2">
      <form action="solvequest.php" class="btn p-0">
        <button id="repeat" class="btn btn-outline rounded" name="repeat" value=1 type="submit">Repeat questionnaire</button>
      </form>
      <a class="btn btn-outline rounded" href="community.php" name="save" value=1 type="button">Back to the main page</a>
      <button id="save" class="btn btn-outline rounded" name="save" value=1 type="button">Save questionnaire to your profile</button>
    </div>

  </main>
</body>

<?php 

$query = "SELECT * FROM User_questionnaire WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
$total = mysqli_num_rows(mysqli_query($mysqli, $query));

$query = "SELECT * FROM User_questionnaire WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire']." AND `Max Score`>=5;";
$passed = mysqli_num_rows(mysqli_query($mysqli, $query));

$difficulty = number_format((1-($passed/$total))*5, 1);
$query = "UPDATE Questionnaire SET Pass_rate=$difficulty WHERE idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
mysqli_num_rows(mysqli_query($mysqli, $query));



myfooter(); 
?>
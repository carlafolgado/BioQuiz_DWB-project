<?php
  require 'include.php';
  myheader('Solve questionnaire');
  require 'navbar.php';
  if ($_REQUEST['idQuestionnaire']) {
    $_SESSION['idQuestionnaire'] = $_REQUEST['idQuestionnaire'];  
  }
  $query = "SELECT * FROM Question WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
  $questions = mysqli_query($mysqli, $query);
    
  if ($_REQUEST['answer']) {
    $score = 0;
    $incorrect = [];

    $query = "SELECT * FROM Question WHERE Questionnaire_idQuestionnaire=".$_SESSION['idQuestionnaire'].";";
    $questions = mysqli_query($mysqli, $query);
    
    while ($question = mysqli_fetch_assoc($questions)) {
      $idQuestion = $question['idQuestion'];
      
      $query = "SELECT * FROM Answer WHERE Question_idQuestion=".$idQuestion.";";
      $answers = mysqli_query($mysqli, $query);
      
      while ($answer = mysqli_fetch_assoc($answers)) {
        $idAnswer = $answer['idAnswer'];

        $incorrect[$idQuestion] = [];          
        if (($answer['Correct'] == 0) and (isset($_REQUEST['answer'][$idAnswer]))) {

          array_push($incorrect[$idQuestion], $idAnswer);          
          
        } else if ( ($answer['Correct'] != 0) and (!isset($_REQUEST['answer'][$idAnswer])) ) {
          array_push($incorrect[$idQuestion], $idAnswer);   
        }
      }
      
      if (!isset($incorrect[$idQuestion])) {
        $score += 1;
      }

    }
    $total_questions = mysqli_num_rows($questions);
    echo '<h2>'.$score.' out of '.$total_questions.' questions right.</h2>';
    echo '<h2>Final mark: '.$score/$total_questions*10..'</h2>';
  }

?>

<script>var incorrect = <?php echo json_encode($incorrect); ?>;</script> 


<body class="bg-light">
  <main class="container">
    <form action="review.php">
    <div class="d-flex flex-row flex-fill">
        <?php
          $n_quest = 1;
          $questionids = array();
          if (isset($questions)) {
            while ($question = mysqli_fetch_assoc($questions)) {
              echo '<div id="question'.$n_quest.'" class="question w-100">
              <div class="d-flex flex-row align-items-center">
              <h2 class="p-2 w-100">Question '.$n_quest.'</h2>
              <button name="'.$question['idQuestion'].'" type="button" class="mark btn btn-outline h-50 w-100" value="unflagged">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
  <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
</svg>
                Flag this question
              </button>
              </div>
              <hr class="feature-divider mt-0" style="border-color: #6da4d1">
              <div class="card">
                      <b><p class="fst-italic p-3 w-100 mb-0">'.$question['Question'].'</p></b>
                        <ul class="list-group list-group-flush">';
              
              array_push($questionids, $question['idQuestion']);
              $query = "SELECT * FROM Answer WHERE Question_idQuestion=".$question['idQuestion'].";";
              $answers = mysqli_query($mysqli, $query);

              while ($answer = mysqli_fetch_assoc($answers)) {
                echo  '<li class="list-group-item">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="answer['.$answer['idAnswer'].']">
                            <label for="answer['.$answer['idAnswer'].']">'.$answer['Answer'].'</label>
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
              <button id="button<?= $id ?>" type="button" class="question-box col-4 col-xl-2 border p-3 m-1" name="<?= $x+1 ?>"><?php echo $x+1 ?></button>
            <?php endforeach ?>
          </div>
          <button class="btn btn-link rounded mt-3" type="submit" name="submit" value="1">Submit questionnaire</button>
      </div>
            </div>
      <div class="d-grid gap-2">
        <button id="prevquestion" class="btn btn-outline rounded mt-3" type="button">Previous question</button>
        <button id="nextquestion" class="btn btn-outline rounded mt-3" type="button">Next question</button>
        <button id="submit" class="btn btn-outline rounded mt-3" type="submit" name="submit" value="1">Submit questionnaire</button>
      </div>

    </form>
  </main>
</body>

<?php myfooter(); ?>

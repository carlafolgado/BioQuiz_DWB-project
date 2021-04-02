<?php
  require_once 'include.php';
  myheader('Question editor');
  require 'navbar.php';

  if ($_REQUEST['title']) {
    $_SESSION['title'] = $_REQUEST['title'];
    $_SESSION['topic'] = $_REQUEST['topic'];
    $_SESSION['description'] = $_REQUEST['description'];

    $questionnaire_query = "INSERT INTO Questionnaire (Topic_Topic, Title, Author, Description) VALUES (\"".$_SESSION['topic']."\",\"".$_SESSION['title']."\", \"".$_SESSION['User']."\", \"".$_SESSION['description']."\")";
    mysqli_query($mysqli, $questionnaire_query);

    $_SESSION['questionnaire_id'] = mysqli_insert_id($mysqli);

  } elseif (!isset($_REQUEST['check'])) {

    echo '<div class="container text-danger"><h2>There must be at least one correct answer!</h1></div>';

    $_SESSION = array_merge($_REQUEST, $_SESSION);

  } elseif (isset($_REQUEST['submit'])) {

    createquestion($_SESSION, $_REQUEST, $mysqli);

    echo '
        <body class="bg-light">
          <main class="container">
            <h1 class="mb-5 mt-5" style="text-align:center;">Questionnaire saved</h1>
            <div class="row justify-content-center">
            <div class="col">
            <a class="btn-outline btn-lg rounded"  style="float: right;" href="profile.php">Back to the main page</a>
            </div>
            <div class="col">
            <a class="btn-outline btn-lg rounded"  style="float: left;" href="newquestionnaire.php">New questionnaire</a>
            </div>
            </div>


          </main>
          </body>';

    exit();

  } elseif ($_REQUEST['question']) {

    createquestion($_SESSION, $_REQUEST, $mysqli);

    unset($_SESSION['check']);
    unset($_SESSION['answer']);
    unset($_SESSION['question']);
  }
?>

<body class="bg-light">

  <main class="container">
    <form action="questioneditor.php" method="POST">
      <div class="form-group" style="margin-top: 20px;">
        <label for="question"><h4>Add question</h4></label>
        <textarea class="form-control" type="text" name="question" placeholder="Write your question" rows="3" required><?php echo $_SESSION['question'];?></textarea>
      </div>
      <h4 style="margin-top: 50px;">Add answers</h4>
      <div id="answers">
        <?php
          for ($x = 1; $x <= 2; $x++) {
            echo '<div id="answer'.$x.'">
                    <div class="form-group" style="margin-top: 30px">

                      <label for="answer['.$x.']">Answer '.$x.'</label>
                      <textarea class="form-control" type="text" name="answer['.$x.']" rows="2">'.$_SESSION["answer"][$x].'</textarea>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" name="check['.$x.']" type="checkbox" value="'.$_SESSION["check"][$x].'" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                        Correct answer
                      </label>
                    </div>
                  </div>';
          }
        ?>
      </div>
      <div class="row ">
        <div class="col-8 float-left">
        <button class="btn border-right" id="more" type="button" name="nextanswer" style = "margin-bottom: 30px; margin-top: 30px">+ Add another answer</button>
        <button class="btn border-left" id="less" type="button" name="deleteanswer" style = "margin-bottom: 30px; margin-top: 30px" >- Delete last answer</button>
      </div>

      <div class="col-4 float-end">
        <button class="btn btn-outline btn-lg" type="submit" name="nextquestion" style = "margin-bottom: 30px; margin-top: 30px ;  float: right;">Add next question</button>
      </div>
    </div>

      <div class="row justify-content-center">
        <button class="btn btn-outline-success ml-3" type="submit" name="submit" style = "margin-bottom: 100px; margin-top: 30px; float:center;">Submit questionnaire</button>

      </div>

    </form>



</main><!-- /.container -->



</body>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>


</html>

<<?php
session_start();

require 'sqlconnection.php';

function myheader($title) {
    echo('<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="myscript.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="custom.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  </head>');
}

function myfooter() {
  echo('<div class="row w-100 p-0 m-0 darkblue mt-3 " style="height:50px">
    <div class="col">
      <p class="text-center mt-2" style="font-family: serif; font-weight: 500; font-size: 18px; text-align: center;"><a class="text-white" href="https://github.com/carlafolgado/BioQuiz_DWB-project.git" target="_blank">Check out the backend of BioQuiz</a></p>
    </div>
  </div></html>');
}

function createquestion($session, $request, $mysqli){
  $question_query = "INSERT INTO Question (Question, Questionnaire_idQuestionnaire) VALUES (\"".$request['question']."\", ".$session['questionnaire_id'].");";
  mysqli_query($mysqli, $question_query);

  $questionid = mysqli_insert_id($mysqli);

  for ($x = 1; $x <= count($request['answer']); $x++){
    if (isset($request['check'][$x])) {
      $on = 1;
    } else {$on = 0;}
    $answer_query = "INSERT INTO Answer (Answer, Question_idQuestion, Correct) VALUES (\"".$request['answer'][$x]."\", ".$questionid.", ".$on.");";
    mysqli_query($mysqli, $answer_query);

  }
}

function errorPage($title, $text) {
  return myheader($title). $text;
}

?>

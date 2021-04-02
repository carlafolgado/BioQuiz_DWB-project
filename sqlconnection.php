<?php
$host = "localhost";
$dbname = "BioQuiz";
$user = "bioquiz";
$password = "bioquiz123";
$mysqli = mysqli_connect($host, $user, $password, $dbname);
if (mysqli_connect_errno()) {
  echo "Error when trying to connect to the database";
  exit();
}

// $query = "INSERT INTO Questionnaire (Topic_idTopic) VALUES (0);";
// $res = mysqli_query($mysqli, $query);

// $questionnaire_query = "INSERT INTO Questionnaire (Topic_idTopic) VALUES (0)";

// $insert1 = mysqli_query($mysqli, $questionnaire_query);

?>

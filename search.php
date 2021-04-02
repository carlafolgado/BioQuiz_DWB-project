<?php
require 'include.php';
myheader('Question editor');
require 'navbar.php';

// print_r($_REQUEST);
// print_r($_POST)
// print_r($_REQUEST);
if ($_REQUEST['search'] and !$_REQUEST['topic']){
  $query = "SELECT * FROM Questionnaire WHERE INSTR(Title, '{$_REQUEST['search']}') > 0 OR INSTR(Description, '{$_REQUEST['search']}') > 0;";
  $res2 = mysqli_query($mysqli, $query);
  // echo $_REQUEST['search'];
  #print_r($_REQUEST);
}
if ($_REQUEST['search'] and $_REQUEST['topic']){
  $ANDconds = [];
  foreach ($_REQUEST['topic'] as $topic){
     #print "$topic";
     $ANDconds[]= "INSTR(Topic_Topic, '{$topic}') > 0";

    // echo $_REQUEST['topic'];
  // print_r($_REQUEST);
  }
  $query = "SELECT * FROM Questionnaire WHERE INSTR(Title, '{$_REQUEST['search']}') > 0 OR INSTR(Description, '{$_REQUEST['search']}') > 0 AND ( " . join(" OR ", $ANDconds). ")";
  #print "$query";
  $res2 = mysqli_query($mysqli, $query);

}
if (!$_REQUEST['search'] and $_REQUEST['topic']){
  $ANDconds = [];
  foreach ($_REQUEST['topic'] as $topic){
     #print "$topic";
     $ANDconds[]= "INSTR(Topic_Topic, '{$topic}') > 0";

    // echo $_REQUEST['topic'];
  // print_r($_REQUEST);
  }
  $query = "SELECT * FROM Questionnaire WHERE ( " . join(" OR ", $ANDconds). ")";
  // print "$query";
  $res2 = mysqli_query($mysqli, $query);

}




if (!mysqli_num_rows($res2)) {
    echo '<main class="container"><p align = center>No results found. Please, try again or create a <a href="newquestionnaire.php"> new questionnaire.</a></p></main>';
    exit();
}

?>

<main class="container min-vh-100">
  <div class="h1 mb-5">Results</div>


  <table class="table " id="dataTable">
    <thead>
      <tr>
        <th scope="col">Questionnaire</th>
        <th scope="col">Dfficulty</th>
        <th scope="col">Topic</th>
        <th scope="col">Author</th>
      </tr>
    </thead>
     <tbody>
<?php

  while ($row = mysqli_fetch_assoc($res2)) {
    echo '
    <tr>
          <td><h5><a href="solvequest.php?idQuestionnaire='.$row['idQuestionnaire'].'">'.$row['Title'].'</a></h5>
          <h6>'.$row['Description'].'</h6></td>
          <td>'.$row['Pass_rate'].'</td>
          <td>'.$row['Topic_Topic'].'</td>
          <td>'.$row['Author'].'</td>
    </tr>';

  }
?>
</tbody>
</table>
<script type="text/javascript">
// <!-- this activates the DataTable element when page is loaded-->
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>
<h5>  </h5>
</main>
</body>

<?php myfooter(); ?>

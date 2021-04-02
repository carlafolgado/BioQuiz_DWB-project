<?php
require 'include.php';
myheader('Question editor');
require 'navbar.php';

if (!isset($_SESSION['search'])){
  $_SESSION['search'] = [
    'query' => "",
    'topic'=>""
  ];
}



$topics_query= "SELECT * FROM Topic;";
$topics= mysqli_query($mysqli, $topics_query);
?>

<body class="bg-light">

<main class="container">
<form name="MainForm" action="search.php" method="POST" enctype="multipart/form-data">
<div class="form-group mt">
  <h1 class="text-center border-bottom" style="margin-top: 5px; margin-bottom:10px; border-color: #6da4d1 !important;" > Search questionnaires </h1>
    <input class="form-control me-2" type="search" placeholder="Enter search term" name="search" aria-label="Search" style="margin-top: 20px;">



<h3 style = "margin-top: 20px"> Topics </h3>

<div class="row">
    <div class= "form-group"style="margin-left: 30px">
      <div class="form-check" >
        <?php while ($row = mysqli_fetch_assoc($topics)){ ?>
          <?php foreach ($row as $topic ) {?>
            <div class="row">
            <label class = "checkbox">
              <input class="form-check-input" type="checkbox" name=topic[] value="<?php echo $topic; ?>" /> <?= "$topic" . "\n"?>
            </div>


        <?php }} ?>
      </div>
    </div>
  </div>
</div>
<div style="text-align:center;">

    <button class="btn btn-outline" type="submit" name="submit">Search</button>
</div>

<?php

if (isset($_REQUEST['submit'])){
  $_SESSION['search'] = $_POST['Search'];
  $_SESSION['topic'] = $_POST['topic'];
}
?>
</form>

</main><!-- /.container -->


    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>


  </body>

<?php myfooter(); ?>

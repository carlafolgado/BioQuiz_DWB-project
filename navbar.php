<?php include_once 'include.php'; ?>
<body>

<nav class="navbar navbar-expand-md darkblue fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand text-white" style="font-family: serif; font-weight: bold; font-size: 20px;" href="profile.php">BioQuiz</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link text-white text-white" aria-current="page" href="./profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="./community.php">Community</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link text-white dropdown-toggle" href="#" role="button" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">Questionnaires</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="newquestionnaire.php">Create questionnaire</a>
            <a class="dropdown-item" href="questionnaires.php">Explore available questionnaires</a>
          </div>
        </li>
      </ul>
        </div>
      <form class=" form-inline d-flex" name="MainForm" action="search.php" method="post" enctype="multipart/form-data">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit" name="submit">Search</button>
        <?php

        if (isset($_REQUEST['submit'])){
          $_SESSION['search'] = $_POST['search'];

        }
        ?>

      </form>


  </div>
</nav>
<!-- <div class="row" style="height: 70px; width:1px"></div> -->

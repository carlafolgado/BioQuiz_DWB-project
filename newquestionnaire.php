<?php
require 'include.php';
myheader('New questionnaire');
require 'navbar.php';
?>

<body class="bg-light">
    <main class="container">
      <h1 class="text-center border-bottom" style="margin-top: 5px; margin-bottom:10px; border-color: #6da4d1 !important;" >Questionnaire editor</h1>
      <form action="questioneditor.php" method="POST">
        <label for="title"><h4 style="margin-top: 20px;" >Questionnaire title</h4></label>
        <textarea name="title" class="form-control mb-3" type="text" placeholder="Add your title" name="title" rows="1" required></textarea>
        <label for="description"><h4>Questionnaire description</h4></label>
        <textarea name="description" class="form-control mb-3" type="text" placeholder="Add a short description of the questionnaire" rows="3"></textarea>
        <label for="topic"><h4>Topic</h4></label>
        <select class="form-control" name="topic">
          <?php
            echo $_SESSION['User'];
            $query = "SELECT * FROM Topic;";
            $topics = mysqli_query($mysqli, $query);
            while ($row = mysqli_fetch_assoc($topics)) {
              echo '<option value="'.$row['Topic'].'">'.$row['Topic'].'</option>';
            }
            ?>
        </select>
        <div style="text-align:center;">
        <button class="btn btn-outline" type="submit" style = "margin-bottom: 100px; margin-top: 30px; ">Submit</button>
      </div>

      </form>

    </main>



</body>

<?php myfooter(); ?>

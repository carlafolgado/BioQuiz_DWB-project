<?php
require 'include.php';
myheader("Profile");
require 'navbar.php';
$id = $_SESSION['User'];
include 'processImage.php';
//if (!isset($_SESSION['username'])) header("location: singin.php");


$query = "SELECT * FROM User WHERE idUser='$id';";
  $res = mysqli_query($mysqli, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $email = $row['email'];
    $username = $row['idUser'];
    $name = $row['Name'];
		$surname = $row['Surname'];
		$current_password = $row['Password'];
    //$profileext = $row['Picture'];
  }
?>
<body class="bg-light">
<main class="container">
<strong> Update your name </strong>
<form action="account.php" method="POST">
<div class="row">
	<div class="col">
		First Name <input type="text"  class="form-control" name="fName" placeholder="<?php if (!$_POST['fName']){echo $name;}else{echo $_POST['fName'];} ?>" />
	</div>
	<div class="col">
		Last name <input type="text" class="form-control" name="lName" placeholder="<?php if (!$_POST['lName']){echo $surname;}else{echo $_POST['lName'];} ?>" />
	</div>
	<div class="col">
		<input type="submit" class="btn btn-outline mt-4" name="nameSubmit" value="Update"/>
	</div>
	<div class="col">
		<?php
			if(isset($_POST['nameSubmit']))
			{

				if ($_POST['fName']) {
					$query = "UPDATE `User` SET Name='{$_POST['fName']}' where idUser='$username'";
					$query_run = mysqli_query($mysqli, $query);

				}
				if ($_POST['lName']) {
					$query = "UPDATE `User` SET Surname='{$_POST['lName']}' where idUser='$username'";
					$query_run = mysqli_query($mysqli, $query);

				}


				if($query_run)
				{

					echo '<p class="text-muted mb-0 mt-4">Data updated</p>';


				}
				else
				{
					echo '<script type="text/javascript"> alert("Data not updated") </script>';
				}
			}
		?>
	</div>
</div>
</form>
<hr />
<strong>Update About me</strong>
<form action="account.php?update=aboutMe" method="POST">
<div class="row">
	<div class="col-auto">
		Email <input type="email" class="form-control" name="email" placeholder="<?php if (!$_POST['email']){echo $email;}else{echo $_POST['email'];} ?>" />
	</div>
	<div class="col-auto">
		<input class="btn btn-outline mt-4" type="submit" name="aboutSubmit" value="Update"/>
	</div>
	<div class="col">
		<?php
			if(isset($_POST['aboutSubmit']))
			{

				if ($_POST['email']){

					//Cambiar username en user_questionnaire

					$query = "UPDATE `User` SET email='{$_POST['email']}' WHERE idUser='{$username}';" ;

					$query_run = mysqli_query($mysqli, $query);
				}


				// UPDATE Questionnaire SET Author=\"".$_POST['Username']."\" WHERE Author='$username';";

				if($query_run)
				{

					echo '<p class="text-muted mb-0 mt-4">Data updated</p>';


				}
				else
				{
					echo '<script type="text/javascript"> alert("Data not updated") </script>';
				}
			}
		?>
	</div>
	</div>
</div>
</form>

<hr/>
<strong>Update password</strong>
<form action="account.php" method="POST">
<div class="row">
	<div class="col">
		Current password <input type="password" class="form-control" name="oldpass" placeholder="Current password" required/>

	</div>
	<div class="col">
		New password <input type="password" class="form-control" name="newpass" placeholder="New password" required/>
	</div>
	<div class="col">
		Repeat new password <input type="password" class="form-control" name="newpass2" placeholder="Repeat new password" required/>
	</div>
	<div class="col-auto">
		<input class="btn btn-outline mt-4" type="submit" name="passwordSubmit" value="Update" />
	</div>
	<div class="col">
		<?php
		if ($_POST['passwordSubmit']) {
			if ($_POST['oldpass'] == $current_password) {
				if ($_POST['newpass']==$_POST['newpass2']) {
					$query = "UPDATE User SET Password='{$_POST['newpass']}' WHERE idUser='{$username}';";
					$res = mysqli_query($mysqli, $query);
					if ($res) {
						echo '<p class="text-muted mb-0 mt-4">Password updated</p>';
					} else {
						echo '<script type="text/javascript"> alert("Password not updated")</script>';
					}
				} else {
					echo '<p class="text-danger mb-0 mt-4">Wrong repeated password</p>';
				}

			}else{
				echo '<p class="text-danger mb-0 mt-4">Wrong current password</p>';
			}

		}
		?>
	</div>
</div>

</form>



<hr />
	<div class="row">
		<div  class= "col-4 offset-md4 form-div">
			<form action="account.php" method="POST" enctype="multipart/form-data">

				<h3>Select profile image</h3>

				<?php if(!empty($msg)): ?>
					<div class="alert <?php echo $css_class; ?>">
						<?php echo $msg; ?>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<label for="profileImage">Profile Image</label>
					<input type="file" name="profileImage" id="profileImage" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" name="save-user" class="btn btn-outline btn-block">Save picture</button>
				</div>
			</form>
		</div>
	</div>
</main>
</body>

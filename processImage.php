<?php
$msg = "";
$css_class="";
if(isset($_POST['save-user'])) {
    $tmp_name = $_FILES['profileImage']['tmp_name'];
    $target_dir = "images";
    $name = basename($_FILES["profileImage"]["tmp_name"]);
    $target_file = "$target_dir/$name";
    $h = move_uploaded_file($tmp_name, "images/".$name);

    if ($h) {
        echo "aaaaa";
        $sql = "UPDATE `User` SET Picture=\"$target_file\" where idUser=\"".$_SESSION['User']."\";";
        echo $sql;
        if(mysqli_query($mysqli, $sql)) {
            $msg = "Image uploaded and saved to database";
            $css_class="alert-success";
        }
    
    } else {
        $msg = "Database Error: Failed to save user";
        $css_class="alert-danger";
    }
}

?>
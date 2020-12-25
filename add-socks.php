<?php
@session_start();

if (!isset($_SESSION["id_user"])) {
    @header("Location: login.php");
}
include("query.php");
$page_title = "Rate my socks - Upload socks";
$css_files = array("form", "upload");
include("header.php");


if (isset($_POST["btnUpload"])) {
    $file_type = $_FILES["file"]["type"];
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $description = $_POST["tbDescription"];
    $errors = array();
    $image = getimagesize($file_tmp);
    $width = $image[0];
    $height = $image[1];
    $size = $_FILES["file"]["size"];
    if ($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/png") {
        $errors[] = "Wrong file type! Only JPEG, JPG or PNG!";
    } else if ($width < 500 || $height < 500) {
        $errors[] = "Image must be larger than 500x500";
    } else if ($size > 2000000) {
        $errors[] = "Image must be smaller than 2MB";
    } else {
        if (count($errors) == 0) {
            $new = time() . "_" . $_SESSION["id_user"] . "." . explode("/", $file_type)[1];

            if (move_uploaded_file($file_tmp, "uploads/socks_images/" . $new)) {
                if ($file_type == 'image/jpeg')
                    $image = imagecreatefromjpeg("uploads/socks_images/" . $new);
                else if ($file_type == 'image/gif')
                    $image = imagecreatefromgif("uploads/socks_images/" . $new);
                else if ($file_type == 'image/png')
                    $image = imagecreatefrompng("uploads/socks_images/" . $new);
                imagejpeg($image, "uploads/socks_images/" . $new, 80);
                
                $status = $_SESSION["id_role"] == 1 ? 1 : 0;
                if(isset($_POST["chbPrivate"])){
                    $status = 3;
                }
                $query_insert_socks = mysqli_query($conn, sprintf("INSERT INTO socks (id_owner, date_posted, image, description, status) VALUES(%d, %d, '%s', '%s', %d)", $_SESSION["id_user"], time(), $new, $description, $status));
                if(!$query_insert_socks){
                    $errors[] = "Upload failed to insert into database.";
                }
                @mail("nikolasimonovic94@gmail.com", "Rate my socks", "Socks uploaded.", "From: webmaster@ratemysocks.000webhostapp.com");
                @header("Location: account.php?uploaded=1");
            }
        }
    }
}
?>
<div class="main">
    <h2>Upload your socks</h2>
    <?php
    if (isset($errors)) {
        foreach ($errors as $e) {
            echo "<p class='form-error'>" . $e . "</p>";
        }
    }
    ?>
    <div class="form">
        <form method="post" action="add-socks.php" enctype="multipart/form-data">
            <div class="form-row"><input type="file" name="file"/></div>
            <div class="form-row"><textarea placeholder="Description" name="tbDescription"></textarea></div>
            <div class="form-row"><input type="checkbox" name="chbPrivate" id="chbPrivate"/><label for="chbPrivate">Private</label></div>
            <div class="form-row"><input type="submit" value="Upload" name="btnUpload"/></div>
        </form>
    </div>
</div>
</body>
</html>
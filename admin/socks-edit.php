<?php
@session_start();
if (!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1) {
    @header("Location: ../index.php");
}

include("../connection.php");
include("../query.php");

$page_title = "Rate my socks - Edit socks - Admin";
include("header.php");
if (isset($_GET["id"])) {
    $selected_socks = getSocksById($_GET["id"]);
}
?>
<div class="form-block">
    <h2>Edit socks</h2>
    <form action="socks-edit.php?id_socks=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">
        <div class="row"><span>Image:</span><input type="file" name="file"/></div>
        <div class="row"><span>Description:</span><input type="text" name="description" value="<?php echo $selected_socks['description']; ?>"/></div>
        <div class="row"><span>Status:</span><select name="status">
                <option value="0" <?php if ($selected_socks["status"] == 0) echo "selected"; ?>>Awaiting approval</option>
                <option value="1" <?php if ($selected_socks["status"] == 1) echo "selected"; ?>>Public</option>
                <option value="2" <?php if ($selected_socks["status"] == 2) echo "selected"; ?>>Rejected</option>
            </select></div>
        <div class="row"><span><input type="submit" value="Save changes" name="btnSave"/></span></div>
    </form>
</div>
</div>
</body>
</html>
<?php
if (isset($_POST["btnSave"])) {
    $status = $_POST["status"];
    $description = addslashes($_POST["description"]);
    $file_type = $_FILES["file"]["type"];
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $selected_socks = getSocksById($_GET["id_socks"]);
    if ($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/png") {
        $query_update = mysqli_query($conn, sprintf("UPDATE socks SET description='%s', status=%d WHERE id_socks=%d", $description, $status, $_GET["id_socks"]));
    } else {
        $new = time() . "_" . $selected_socks["id_owner"] . "." . explode("/", $file_type)[1];
        if (move_uploaded_file($file_tmp, "../uploads/socks_images/" . $new)) {
            $query_update = mysqli_query($conn, sprintf("UPDATE socks SET description='%s', status=%d, image='%s' WHERE id_socks=%d", $description, $status, $new, $_GET["id_socks"]));
        }
    }

    if ($query_update) {
        header("Location: socks.php");
    }
}
?>
<?php
@session_start();
if (!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1) {
    @header("Location: ../index.php");
}

include("../connection.php");
if (isset($_GET["delete"])) {
    $query_delete_comment = mysqli_query($conn, sprintf("DELETE FROM comments WHERE id_comment=%d", $_GET["delete"]));
    @header("Location: comments.php");
}

$page_title = "Rate my socks - Comments - Admin";
include("header.php");
$query_select_comments = mysqli_query($conn, "SELECT * FROM comments c JOIN users u ON c.id_user=u.id_user");

echo "<h2>Comments</h2>";
echo "<table>";
echo "<tr><th>Comment</th><th>User</th><th>Socks</th><th>Date posted</th><th>Edit</th><th>Delete</th><th>Visible</th></tr>";
while ($q = mysqli_fetch_array($query_select_comments)) {
    $visible = $q["visible"] == 1 ? "checked" : "";
    echo "<tr><td>" . $q["comment"] . "</td><td><a href='../user.php?id=" . $q["id_user"] . "'>" . $q["username"] . "</a></td><td align='center'><a href='../socks.php?id=" . $q["id_socks"] . "'><i class='fa fa-link'></i></a></td><td>" . date("M d Y H:i:s", $q["date_posted"]) . "</td><td><a href='comments-edit.php?id=" . $q["id_comment"] . "'><img src='../images/edit_icon.png' alt='Edit' class='img-edit'></a></td><td class='img-delete'><span data-url='comments.php?delete=" . $q["id_comment"] ."' class='delete-verify'><img src='../images/delete_icon.png' alt='Delete'/></span></td><td class='check-visible-wrap'><span class='check-visible'><input type='checkbox' class='comment-check' value='" . $q["visible"] . "' id='comment" . $q["id_comment"] . "' " . $visible . "/><label for='comment" . $q["id_comment"] . "'></label></span></td></tr>";
}
echo "</table>";
?>

</div>
<div class="delete-pop-up-wrap">
    <div class="delete-pop-up">
        <p>Are you sure?</p>
        <div class="yes-no-buttons">
            <a id="delete-yes" href="">Yes</a>
            <span id="delete-no">No</span>
        </div>
    </div>
</div>
</body>
</html>
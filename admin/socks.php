<?php
@session_start();
if (!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1) {
    @header("Location: ../index.php");
}

include_once("../connection.php");
if (isset($_GET["delete"])) {
    $query_delete_socks = mysqli_query($conn, sprintf("DELETE FROM socks WHERE id_socks=%d", $_GET["delete"]));
    @header("Location: socks.php");
}
if (isset($_GET["approve"])) {
    $query_approve_socks = mysqli_query($conn, sprintf("UPDATE socks SET status=1 WHERE id_socks=%d", $_GET["approve"]));
    @header("Location: socks.php");
}
if (isset($_GET["reject"])) {
    $query_approve_socks = mysqli_query($conn, sprintf("UPDATE socks SET status=2 WHERE id_socks=%d", $_GET["reject"]));
    @header("Location: socks.php");
}

$page_title = "Rate my socks - Socks - Admin";
include("header.php");
include("../query.php");
// status = 0 AWAITING, status = 1 PUBLIC, status = 2 REJECTED

$query_select_socks = mysqli_query($conn, "SELECT * FROM socks s JOIN users u ON s.id_owner=u.id_user WHERE status<>0 ORDER BY date_posted DESC");
$query_select_socks_awaiting = mysqli_query($conn, "SELECT * FROM socks s JOIN users u ON s.id_owner=u.id_user WHERE status=0 ORDER BY date_posted DESC");

echo "<h2>Socks</h2>";
if (mysqli_num_rows($query_select_socks_awaiting) > 0) {
    echo "<h3>Awaiting approval</h3>";
    echo "<table>";
    echo "<tr><th>Posted by</th><th>URL</th><th>Description</th><th>Date created</th><th>Likes</th><th>Image</th><th>Approve</th><th>Reject</th></tr>";
    while ($q = mysqli_fetch_array($query_select_socks_awaiting)) {
        echo "<tr><td><a href='../user.php?id=" . $q["id_user"] . "'>" . $q["username"] . "</a></td><td align='center'><a href='../socks.php?id=".$q["id_socks"]."'><i class='fa fa-link'></i></a></td><td>" . $q["description"] . "</td><td>" . date("d-m-Y H:i:s", $q["date_posted"]) . "</td><td>".getSocksLikes($q["id_socks"])."</td><td><img src='../uploads/socks_images/" . $q["image"] . "' width='60' height='60' alt='Socks'/></td><td class='img-check'><a href='socks.php?approve=" . $q["id_socks"] . "'><img src='../images/check_icon.png' alt='Check'></a></td><td class='img-delete'><a href='socks.php?reject=" . $q["id_socks"] . "'><img src='../images/delete_icon.png' alt='Delete'/></a></td></tr>";
    }
    echo "</table>";
}
echo "<h3>Approved and rejected</h3>";
echo "<table>";
echo "<tr><th>Posted by</th><th>URL</th><th>Description</th><th>Date created</th><th>Likes</th><th>Image</th><th>Status</th><th>Edit</th><th>Delete</th></tr>";
while ($q = mysqli_fetch_array($query_select_socks)) {
    switch ($q["status"]) {
        case 0:
            $status = "Awaiting";
            break;
        case 1:
            $status = "Public";
            break;
        case 2:
            $status = "Rejected";
            break;
    }
    echo "<tr><td><a href='../user.php?id=" . $q["id_user"] . "'>" . $q["username"] . "</a></td><td align='center'><a href='../socks.php?id=".$q["id_socks"]."'><i class='fa fa-link'></i></a></td><td>" . $q["description"] . "</td><td>" . date("d-m-Y H:i:s", $q["date_posted"]) . "</td><td>".getSocksLikes($q["id_socks"])."</td><td><img src='../uploads/socks_images/" . $q["image"] . "' width='60' height='60' alt='Socks'/></td><td>" . $status . "</td><td><a href='socks-edit.php?id=" . $q["id_socks"] . "'><img src='../images/edit_icon.png' alt='Edit' class='img-edit'></a></td><td class='img-delete'><span data-url='socks.php?delete=" . $q["id_socks"] . "' class='delete-verify'><img src='../images/delete_icon.png' alt='Delete'/></span></td></tr>";
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
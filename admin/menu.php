<?php
@session_start();
if (!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1) {
    @header("Location: ../index.php");
}

include_once("../connection.php");
if (isset($_GET["delete"])) {
    $query_delete_news = mysqli_query($conn, sprintf("DELETE FROM menu WHERE id_menu=%d", $_GET["delete"]));
    @header("Location: menu.php");
}

$page_title = "Rate my socks - Menu - Admin";
include_once("header.php");
$query_select_menu = mysqli_query($conn, "SELECT * FROM menu");

echo "<h2>Menu</h2>";
echo "<a class='add-new' href='menu-add.php'>Add menu item</a>";
echo "<table>";
echo "<tr><th>Menu name</th><th>Menu page</th><th>Menu font-awesome icon</th><th>Edit</th><th>Delete</th><th>Visible</th></tr>";
while ($q = mysqli_fetch_array($query_select_menu)) {
    $visible = $q["visible"] == 1 ? "checked" : "";
    echo "<tr><td>" . $q["menu_name"] . "</td><td>" . $q["menu_page"] . "</td><td>" . $q["menu_icon"] . "</td><td><a href='menu-edit.php?id=" . $q["id_menu"] . "'><img src='../images/edit_icon.png' alt='Edit' class='img-edit'></a></td><td class='img-delete'><span data-url='menu.php?delete=" . $q["id_menu"] . "' class='delete-verify'><img src='../images/delete_icon.png' alt='Delete'/></span></td><td class='check-visible-wrap'><span class='check-visible'><input type='checkbox' class='menu-check' value='" . $q["visible"] . "' id='menu-item" . $q["id_menu"] . "' " . $visible . "/><label for='menu-item" . $q["id_menu"] . "'></label></span></td></tr>";
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
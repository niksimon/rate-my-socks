<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    if(isset($_GET["delete"])){
        $query_delete_user = mysqli_query($conn, sprintf("DELETE FROM users WHERE id_user=%d", $_GET["delete"]));
        @header("Location: users.php");
    }
    
    $page_title = "Rate my socks - Users - Admin";
    include_once("header.php");
    $query_select_users = mysqli_query($conn, "SELECT * FROM users u JOIN roles r ON u.id_role=r.id_role");
    
    echo "<h2>Users</h2>";
    echo "<a class='add-new' href='user-add.php'>Add user</a>";
    echo "<table>";
    echo "<tr><th>Username</th><th>E-mail</th><th>Date created</th><th>Role</th><th>Edit</th><th>Delete</th></tr>";
    while($q = mysqli_fetch_array($query_select_users)){
        echo "<tr><td>".$q["username"]."</td><td>".$q["email"]."</td><td>".date("M d Y H:i:s", $q["date_created"])."</td><td>".$q["role_name"]."</td><td><a href='user-edit.php?id=".$q["id_user"]."'><img src='../images/edit_icon.png' alt='Edit' class='img-edit'></a></td><td class='img-delete'><span data-url='users.php?delete=".$q["id_user"]."' class='delete-verify'><img src='../images/delete_icon.png' alt='Delete'/></span></td></tr>";
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
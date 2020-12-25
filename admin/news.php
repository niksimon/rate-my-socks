<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    if(isset($_GET["delete"])){
        $query_delete_news = mysqli_query($conn, sprintf("DELETE FROM news WHERE id_news=%d", $_GET["delete"]));
        @header("Location: news.php");
    }
    
    $page_title = "Rate my socks - News - Admin";
    include_once("header.php");
    $query_select_news = mysqli_query($conn, "SELECT * FROM news n JOIN users u ON n.posted_by=u.id_user ORDER BY date_posted DESC");
    
    echo "<h2>News</h2>";
    echo "<a class='add-new' href='news-add.php'>Add news</a>";
    echo "<table>";
    echo "<tr><th>Title</th><th>Description</th><th>Date posted</th><th>Posted by</th><th>Edit</th><th>Delete</th><th>Visible</th></tr>";
    while($q = mysqli_fetch_array($query_select_news)){
        $visible = $q["visible"] == 1 ? "checked" : "";
        echo "<tr><td>".$q["title"]."</td><td>".$q["description"]."</td><td>".date("M d Y H:i:s", $q["date_posted"])."</td><td>".$q["username"]."</td><td><a href='news-edit.php?id=".$q["id_news"]."'><img src='../images/edit_icon.png' alt='Edit' class='img-edit'></a></td><td class='img-delete'><span data-url='news.php?delete=".$q["id_news"]."' class='delete-verify'><img src='../images/delete_icon.png' alt='Delete'/></span></td><td class='check-visible-wrap'><span class='check-visible'><input type='checkbox' class='news-check' value='" . $q["visible"] . "' id='news" . $q["id_news"] . "' " . $visible . "/><label for='news" . $q["id_news"] . "'></label></span></td></tr>";
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
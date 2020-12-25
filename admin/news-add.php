<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Add news - Admin";
    include_once("header.php");
    
?>
    <div class="form-block">
    <h2>Add news</h2>
    <form action="news-add.php" method="post">
	<div class="row"><span>Title:</span><input type="text" name="title"/></div>
        <div class="row"><span>Description:</span><textarea name="description"></textarea></div>
        <div class="row"><span><input type="submit" value="Add news" name="btnAdd"/></span></div>
        </form>
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST["btnAdd"])){
	$title = $_POST["title"];
        $description = $_POST["description"];
	
	$query_insert = mysqli_query($conn, sprintf("INSERT INTO news (title, description, date_posted, posted_by, visible) VALUES('%s', '%s', %d, %d, %d)", $title, $description, time(), $_SESSION["id_user"], 1));

	if($query_insert){
            header("Location: news.php");
	}
    }
?>
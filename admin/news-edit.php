<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Edit news - Admin";
    include_once("header.php");
    if(isset($_GET["id"])){
        $query_select_news = mysqli_query($conn, sprintf("SELECT * FROM news WHERE id_news='%d'", $_GET["id"]));
        $selected_news = mysqli_fetch_array($query_select_news);
    }
?>
    <div class="form-block">
    <h2>Edit news</h2>
    <form action="news-edit.php?id_news=<?php echo $_GET["id"]; ?>" method="post">
	<div class="row"><span>Title:</span><input type="text" name="title" value="<?php echo $selected_news['title']; ?>"/></div>
        <div class="row"><span>Description:</span><textarea name="description"><?php echo $selected_news['description']; ?></textarea></div>
        <div class="row"><span>Posted by:</span><select name="user">
	<?php 
            $query_users = mysqli_query($conn, "SELECT * FROM users WHERE id_role=1");
            while($r = mysqli_fetch_array($query_users)){
		echo "<option value='".$r['id_user']."' selected='selected'>".$r['username']."</option>";
            }
	?>
	</select></div>
        <div class="row"><span><input type="submit" value="Save changes" name="btnSave"/></span></div>
        </form>
    </div>
</div>
    </body>
    </html>
<?php
if(isset($_POST["btnSave"])){
	$title = $_POST["title"];
	$description = $_POST["description"];
	$user = $_POST["user"];
	$query_update = mysqli_query($conn, sprintf("UPDATE news SET title='%s', description='%s', posted_by=%d WHERE id_news=%d", $title, $description, $user, $_GET['id_news']));

	if($query_update){
            header("Location: news.php");
	}
}
?>
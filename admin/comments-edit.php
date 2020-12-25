<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Edit comment - Admin";
    include_once("header.php");
    if(isset($_GET["id"])){
        $query_select_comment = mysqli_query($conn, sprintf("SELECT * FROM comments WHERE id_comment='%d'", $_GET["id"]));
        $selected_comment = mysqli_fetch_array($query_select_comment);
    }
?>
    <div class="form-block">
    <h2>Edit comment</h2>
    <form action="comments-edit.php?id_comment=<?php echo $_GET["id"]; ?>" method="post">
        <div class="row"><span>Comment:</span><textarea name="comment"><?php echo $selected_comment['comment']; ?></textarea></div>
        <div class="row"><span><input type="submit" value="Save changes" name="btnSave"/></span></div>
        </form>
    </div>
</div>
    </body>
    </html>
<?php
if(isset($_POST["btnSave"])){
	$comment = $_POST["comment"];
	$query_update = mysqli_query($conn, sprintf("UPDATE comments SET comment='%s' WHERE id_comment=%d", $comment, $_GET['id_comment']));

	if($query_update){
            header("Location: comments.php");
	}
}
?>
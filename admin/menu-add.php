<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Add menu item - Admin";
    include_once("header.php");
    
?>
    <div class="form-block">
    <h2>Add menu item</h2>
    <form action="menu-add.php" method="post">
	<div class="row"><span>Menu name:</span><input type="text" name="menu-name"/></div>
        <div class="row"><span>Menu page:</span><input type="text" name="menu-page"></div>
        <div class="row"><span>Menu icon:</span><input type="text" name="menu-icon"></div>
        <div class="row"><span><input type="submit" value="Add menu item" name="btnAdd"/></span></div>
        </form>
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST["btnAdd"])){
	$name = $_POST["menu-name"];
        $page = $_POST["menu-page"];
        $icon = $_POST["menu-icon"];
	
	$query_insert = mysqli_query($conn, sprintf("INSERT INTO menu (menu_name, menu_page, menu_icon, visible) VALUES('%s', '%s', '%s', %d)", $name, $page, $icon, 1));

	if($query_insert){
            header("Location: menu.php");
	}
    }
?>
<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Edit menu item - Admin";
    include_once("header.php");
    if(isset($_GET["id"])){
        $query_select_menu = mysqli_query($conn, sprintf("SELECT * FROM menu WHERE id_menu='%d'", $_GET["id"]));
        $selected_menu = mysqli_fetch_array($query_select_menu);
    }
?>
    <div class="form-block">
    <h2>Edit menu item</h2>
    <form action="menu-edit.php?id_menu=<?php echo $_GET["id"]; ?>" method="post">
	<div class="row"><span>Menu name:</span><input type="text" name="menu-name" value="<?php echo $selected_menu['menu_name']; ?>"/></div>
        <div class="row"><span>Menu page:</span><input type="text" name="menu-page" value="<?php echo $selected_menu['menu_page']; ?>"/></div>
        <div class="row"><span>Menu icon:</span><input type="text" name="menu-icon" value="<?php echo $selected_menu['menu_icon']; ?>"/></div>
        <div class="row"><span><input type="submit" value="Save changes" name="btnSave"/></span></div>
        </form>
    </div>
</div>
    </body>
    </html>
<?php
if(isset($_POST["btnSave"])){
	$name = $_POST["menu-name"];
	$page = $_POST["menu-page"];
        $icon = $_POST["menu-icon"];
	$query_update = mysqli_query($conn, sprintf("UPDATE menu SET menu_name='%s', menu_page='%s', menu_icon='%s' WHERE id_menu=%d", $name, $page, $icon, $_GET['id_menu']));

	if($query_update){
            header("Location: menu.php");
	}
}
?>
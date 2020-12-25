<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Edit user - Admin";
    include_once("header.php");
    if(isset($_GET["id"])){
        $query_select_user = mysqli_query($conn, sprintf("SELECT * FROM users WHERE id_user='%d'", $_GET["id"]));
        $selected_user = mysqli_fetch_array($query_select_user);
    }
?>
    <div class="form-block">
    <h2>Edit user</h2>
    <form action="user-edit.php?id_user=<?php echo $_GET["id"]; ?>" method="post">
	<div class="row"><span>Username:</span><input type="text" name="username" value="<?php echo $selected_user['username']; ?>"/></div>
	<div class="row"><span>Password:</span><input type="password" name="password"/></div>
	<div class="row"><span>E-mail:</span><input type="text" name="email" value="<?php echo $selected_user['email']; ?>"/></div>
	<div class="row"><span>Role:</span><select name="role">
	<?php 
            $query_roles = mysqli_query($conn, "SELECT * FROM roles");
            while($r = mysqli_fetch_array($query_roles)){
            if($selected_user['id_role'] == $r['id_role'])
		echo "<option value='".$r['id_role']."' selected='selected'>".$r['role_name']."</option>";
            else
                echo "<option value='".$r['id_role']."'>".$r['role_name']."</option>";
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
	$username = $_POST["username"];
	if(!empty($_POST["password"]))
            $password = md5(trim($_POST["password"]));
	$email = $_POST["email"];
	$role = $_POST["role"];

	if(isset($password))
		$query = sprintf("UPDATE users SET username='%s', password='%s', email='%s', id_role=%d WHERE id_user=%d", $username, $password, $email, $role, $_GET['id_user']);
	else
		$query = sprintf("UPDATE users SET username='%s', email='%s', id_role=%d WHERE id_user=%d", $username, $email, $role, $_GET['id_user']);
	
	$query_update = mysqli_query($conn, $query);

	if($query_update){
            header("Location: users.php");
	}
}
?>
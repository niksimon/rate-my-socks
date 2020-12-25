<?php
    @session_start();
    if(!isset($_SESSION["id_role"]) || $_SESSION["id_role"] != 1){
        @header("Location: ../index.php");
    }
    
    include_once("../connection.php");
    
    $page_title = "Rate my socks - Add user - Admin";
    include_once("header.php");
    
?>
    <div class="form-block">
    <h2>Add user</h2>
    <form action="user-add.php" method="post">
	<div class="row"><span>Username:</span><input type="text" name="username"/></div>
	<div class="row"><span>Password:</span><input type="password" name="password"/></div>
	<div class="row"><span>E-mail:</span><input type="text" name="email"/></div>
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
        <div class="row"><span><input type="submit" value="Add user" name="btnAdd"/></span></div>
        </form>
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST["btnAdd"])){
	$username = $_POST["username"];
        $password = md5(trim($_POST["password"]));
	$email = $_POST["email"];
	$role = $_POST["role"];
	
	$query_insert = mysqli_query($conn, sprintf("INSERT INTO users (username, password, email, date_created, id_role) VALUES('%s', '%s', '%s', %d, %d)", $username, $password, $email, time(), $role));

	if($query_insert){
            header("Location: users.php");
	}
    }
?>
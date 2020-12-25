<?php
    include("connection.php");
    if(isset($_POST["btnLogin"])){
	$errors = array();
	$username = $_POST["loginUsername"];
	$password = md5($_POST["loginPassword"]);
        $query_select_user = mysqli_query($conn, sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'", $username, $password));
        if(mysqli_num_rows($query_select_user) == 0){
            $errors[] = "Wrong username or password!";
        }
        else{
            $q = mysqli_fetch_array($query_select_user);
            $query_last_login = mysqli_query($conn, sprintf("UPDATE users SET last_login=%d WHERE id_user=%d", time(), $q["id_user"]));
            $_SESSION["id_user"] = $q["id_user"];
            $_SESSION["id_role"] = $q["id_role"];
            $_SESSION["username"] = $q["username"];
            @header("Location: account.php");
        }
    }
?>
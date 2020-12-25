<?php
@session_start();

if (!isset($_SESSION["id_user"])) {
    @header("Location: index.php");
}
include("connection.php");
$page_title = "Rate my socks - Change password";
$css_files = array("form");
include("header.php");

if (isset($_POST["btnSave"])) {
    $errors = array();
    $password = $_POST["tbPassword"];
    
    if (!preg_match("/^[a-zA-Z0-9]{4,30}$/", $password) || empty($password))
        $errors['password'] = "Password is incorrect!";

    if (count($errors) == 0) {
        $query_change = mysqli_query($conn, sprintf("UPDATE users SET password='%s' WHERE id_user=%d", md5($password), $_SESSION["id_user"]));
        if ($query_change) {
            @header("Location: account.php");
        }
    }
}
?>
<div class="main">
    <h2>Change password</h2>
    <?php
    if (isset($errors)) {
        foreach ($errors as $e) {
            echo "<p class='form-error'>" . $e . "</p>";
        }
    }
    ?>
    <div class="form">
        <form method="post" action="change-password.php">
            <div class="form-row"><input type="password" id="tbPassword" name="tbPassword" placeholder="New password"></div>
            <div class="form-row"><input type="submit" value="Apply" name="btnSave"/></div>
        </form>
    </div>
    </div>
        <script>
            window.addEventListener("load", function(){
                document.getElementById("tbPassword").addEventListener("blur", function(){
                    if(!/^[a-zA-Z0-9]{4,30}$/.test(this.value))
			this.style.borderColor = "#ff849a";
                    else
			this.style.borderColor = "#bbb";
                }); 
            });


</script>
        </body>
        </html>
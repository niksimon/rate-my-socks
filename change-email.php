<?php
@session_start();

if (!isset($_SESSION["id_user"])) {
    @header("Location: index.php");
}
include("connection.php");
$page_title = "Rate my socks - Change email";
$css_files = array("form");
include("header.php");

if (isset($_POST["btnSave"])) {
    $errors = array();
    $email = $_POST["tbEmail"];

    if (!preg_match("/^[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+)+$/", $email)) {
        $errors['email'] = "E-mail is incorrect!";
    } else {
        $query_email = mysqli_query($conn, sprintf("SELECT * FROM users WHERE email='%s'", $email));
        if (mysqli_num_rows($query_email) > 0)
            $errors['email_exists'] = "That e-mail is already used!";
    }

    if (count($errors) == 0) {
        $query_change = mysqli_query($conn, sprintf("UPDATE users SET email='%s' WHERE id_user=%d", $email, $_SESSION["id_user"]));
        if ($query_change) {
            @header("Location: account.php");
        }
    }
}
?>
<div class="main">
    <h2>Change e-mail</h2>
    <?php
    if (isset($errors)) {
        foreach ($errors as $e) {
            echo "<p class='form-error'>" . $e . "</p>";
        }
    }
    ?>
    <div class="form">
        <form method="post" action="change-email.php">
            <div class="form-row"><input type="text" id="tbEmail" name="tbEmail" placeholder="New e-mail"></div>
            <div class="form-row"><input type="submit" value="Apply" name="btnSave"/></div>
        </form>
    </div>
    </div>
        <script>
            window.addEventListener("load", function () {
                document.getElementById("tbEmail").addEventListener("blur", function () {
                    if (!/^[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+)+$/.test(this.value))
                        this.style.borderColor = "#ff849a";
                    else
                        this.style.borderColor = "#bbb";
                });
            });   

        </script>
        </body>
        </html>
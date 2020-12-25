<?php
@session_start();

$page_title = "Rate my socks - Contact us";
$css_files = array("form", "contact");
include_once("header.php");
?>
<div class="main">
    <h2>Send us a message</h2>
    <?php
    if (isset($_POST["btnSend"])) {
        $name = $_POST["tbName"];
        $email = $_POST["tbEmail"];
        $msg = $_POST["tbMessage"];
        $headers = 'From: ' . $email;
        $errors = array();

        if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $name)) {
            $errors['name'] = "Name is incorrect!";
        }
        if (!preg_match("/^[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+)+$/", $email)) {
            $errors['email'] = "E-mail is incorrect!";
        }

        if (isset($errors) && count($errors) == 0) {
            if (!@mail("nikolasimonovic94@gmail.com", "Rate my socks", $msg, $headers)) {
                $mail_success = false;
            } else {
                $mail_success = true;
            }
        }
    }
    ?>
    <div class="form">
    <?php
    if (isset($errors)) {
        foreach ($errors as $e) {
            echo "<p class='form-error'>" . $e . "</p>";
        }
    }
    if (isset($mail_success)) {
        if (!$mail_success) {
            echo "<p class='form-error'>Mail sending failed!</p>";
        } else {
            echo "<p class='form-info'>Mail sent!</p>";
        }
    }
    ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row"><input type="text" name="tbName" placeholder="Name" value="<?php if (isset($_POST["tbName"])) echo $_POST["tbName"]; ?>"/></div>
            <div class="form-row"><input type="email" name="tbEmail" placeholder="E-mail" value="<?php if (isset($_POST["tbEmail"])) echo $_POST["tbEmail"]; ?>"/></div>
            <div class="form-row"><textarea placeholder="Your message" name="tbMessage"></textarea></div>
            <div class="form-row"><input type="submit" value="Send" name="btnSend"/></div>
        </form>
    </div>
    </div>
        </body>
        </html>
<?php
@session_start();

if (isset($_SESSION["id_user"])) {
    @header("Location: account.php");
}
include("register-check.php");
$page_title = "Rate my socks - Create an account";
$css_files = array("form");
include("header.php");
?>
<div class="main">
    <h2>Create an account</h2>
    <?php
    if (isset($errors) && count($errors) > 0) {
        foreach ($errors as $e) {
            echo "<p class='form-error'>" . $e . "</p>";
        }
    }
    ?>
    <div class="form">
        <form method="post" action="register.php">
            <div class="form-row"><input type="text" id="regUsername" name="regUsername" placeholder="Username"></div>
            <div class="form-row"><input type="password" id="regPassword" name="regPassword" placeholder="Password"></div>
            <div class="form-row"><input type="text" id="regEmail" name="regEmail" placeholder="E-mail"></div>
            <div class="form-row">
                <div class="captcha-wrap">
                    <span class="captcha-loading"><img src='images/loader2.gif' alt='Loading...'/></span>
                    <div class="g-recaptcha" data-sitekey="6Ldy2SgUAAAAAE1tqrLdl9sptBsvBpIueKdj3bAK"></div>
                </div>
            </div>
            <div class="form-row"><input type="submit" value="Sign up" name="btnRegister"/></div>
        </form>
    </div>
</div>
<script>
    window.addEventListener("load", function () {
        document.getElementById("regUsername").addEventListener("blur", function () {
            if (!/^[a-zA-Z0-9]{3,30}$/.test(this.value))
                this.style.borderColor = "#ff849a";
            else
                this.style.borderColor = "#bbb";
        });
        document.getElementById("regPassword").addEventListener("blur", function () {
            if (!/^[a-zA-Z0-9]{4,30}$/.test(this.value))
                this.style.borderColor = "#ff849a";
            else
                this.style.borderColor = "#bbb";
        });
        document.getElementById("regEmail").addEventListener("blur", function () {
            if (!/^[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+)+$/.test(this.value))
                this.style.borderColor = "#ff849a";
            else
                this.style.borderColor = "#bbb";
        });
    });

</script>
</body>
</html>
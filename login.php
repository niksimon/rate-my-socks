<?php
@session_start();

if (isset($_SESSION["id_user"])) {
    @header("Location: account.php");
}

$page_title = "Rate my socks - Sign in";
$css_files = array("form");
include("login-check.php");
include("header.php");
?>
<div class="main">
    <h2>Sign in</h2>
    <div class="form">
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
        <?php
        
        if (isset($errors)) {
            foreach ($errors as $e) {
                echo "<p class='form-error'>" . $e . "</p>";
            }
        }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row"><input type="text" id="loginUsername" name="loginUsername" placeholder="Username"></div>
            <div class="form-row"><input type="password" id="loginPassword" name="loginPassword" placeholder="Password"></div>
            <div class="form-row"><input type="submit" value="Sign in" name="btnLogin"/></div>
        </form>
    </div>
    </div>
        <script>
            window.addEventListener("load", function () {
                document.getElementById("loginUsername").addEventListener("blur", function () {
                    if (!/^[a-zA-Z0-9]{2,30}$/.test(this.value))
                        this.style.borderColor = "#ff849a";
                    else
                        this.style.borderColor = "#bbb";
                });
                document.getElementById("loginPassword").addEventListener("blur", function () {
                    if (!/^[a-zA-Z0-9]{4,30}$/.test(this.value))
                        this.style.borderColor = "#ff849a";
                    else
                        this.style.borderColor = "#bbb";
                });
            });

        </script>
        </body>
        </html>
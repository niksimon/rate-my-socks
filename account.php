<?php
@session_start();

if (!isset($_SESSION["id_user"])) {
    @header("Location: login.php");
}
include("query.php");
$page_title = "Rate my socks - My account";
$css_files = array("account");
include("header.php");

if (isset($_GET["delete"])) {
    deleteSocks($_SESSION["id_user"], $_GET["delete"]);
    @header("Location: account.php");
}
?>
<div class="main">
    <h2>My account</h2>
    <?php
    if (isset($_GET["uploaded"]) && $_SESSION["id_role"] != 1) {
        echo "<p class='info2'>Successfully uploaded! Your post will be public if admin approves it.</p>";
    }
    ?>
    <a class="button" href="logout.php">Sign out</a>
    <?php
    if ($_SESSION["id_role"] == 1) {
        echo "<a class='button' target='_blank' href='admin/socks.php'>Admin</a>";
    }
    ?>
    <a class="button" href="change-password.php">Change password</a>
    <a class="button" href="change-email.php">Change e-mail</a>
    <p>Username: <b><?php echo $_SESSION["username"]; ?></b></p>
    <p>E-mail: <b><?php
            $user = getUser($_SESSION["id_user"]);
            echo $user["email"];
            ?></b></p>
    <p>Account created: <b>
            <?php
            echo date("F d Y H:i:s", $user["date_created"]);
            ?></b></p>
    <p style='margin-bottom:0'>Your socks:</p>
    <?php
    $user_socks = getUserSocks($_SESSION["id_user"]);
    if (is_int($user_socks) && $user_socks == 0) {
        echo "<p class='info'>You haven't uploaded any socks. Click <a href='add-socks.php'>here</a> to upload.</p>";
    } else {
        
        echo "<div class='account-content'>";
        
        $per_page = 16;

        $count = mysqli_num_rows($user_socks);
        $num_pages = ceil($count / $per_page);
        
        $page = isset($_GET["page"]) && (int)$_GET["page"] > 0 && (int)$_GET["page"] <= $num_pages ? $_GET["page"] : 1;
        $user_socks_offset = getUserSocksOffset($_SESSION["id_user"], $per_page, ($page - 1) * $per_page);

        while ($q = mysqli_fetch_array($user_socks_offset)) {
            switch ($q["status"]) {
                case 0:
                    $status_class = "approval";
                    $status = "Awaiting approval";
                    break;
                case 1:
                    $status_class = "public";
                    $status = "Public";
                    $change_status = "<a href='change-status.php?id_socks=".$q["id_socks"]."' class='change-status'>Make private</a>";
                    break;
                case 2:
                    $status_class = "reject";
                    $status = "Rejected";
                    break;
                case 3:
                    $status_class = "private";
                    $status = "Private";
                    $change_status = "<a href='change-status.php?id_socks=".$q["id_socks"]."' class='change-status'>Make public</a>";
                    break;
            }
            
            echo "<div class='account-content-item'><a href='account.php?delete=" . $q["id_socks"] . "' class='socks-delete'><img src='images/delete_icon.png' alt='Delete'/></a><a href='socks.php?id=" . $q["id_socks"] . "'><div class='account-content-img' style='background-image:url(uploads/socks_images/".$q["image"].")'></div></a><div class='socks-details'><span class='" . $status_class . "'>$status</span>$change_status</div></div>";
            
        }
        echo "<div class='clear'></div></div>";
        
        if ($num_pages > 1) {
            echo "<div class='pages'>";
            for ($i = 0; $i < $num_pages; $i++) {
                if ($page == $i + 1) {
                    echo "<a class='current' href='account.php?page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
                } else {
                    echo "<a href='account.php?page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
                }
            }
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>
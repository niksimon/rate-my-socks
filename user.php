<?php
@session_start();

include("query.php");
$page_title = "Rate my socks - User";
$css_files = array("user");
include("header.php");

?>
<div class="main">
    <?php
    if (isset($_GET["id"])) {
        $id_user = $_GET["id"];
        $query_select_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user=" . (int) $id_user);
        if (mysqli_num_rows($query_select_user) == 0) {
            echo "<h2>User not found</h2><p class='info'>This user doesn't exist!</p>";
        } else {
            $q = mysqli_fetch_array($query_select_user);
            echo "<h2>" . $q["username"] . "</h2>";
            echo "<p>Member for: ";
            $days = floor((time() - $q["date_created"]) / (24 * 3600));
            if ($days > 0) {
                echo " " . $days;
                echo $days > 1 ? " days" : " day";
            } else {
                $hours = floor((time() - $q["date_created"]) / (3600));
                if ($hours > 0) {
                    echo " " . $hours;
                    echo $hours > 1 ? " hours" : " hour";
                } else {
                    $minutes = floor((time() - $q["date_created"]) / 60);
                    if ($minutes > 0) {
                        echo " " . $minutes;
                        echo $minutes > 1 ? " minutes" : " minute";
                    } else {
                        $seconds = floor(time() - $q["date_created"]);
                        echo " " . $seconds;
                        echo $seconds != 1 ? " seconds" : " second";
                    }
                }
            }
            echo "</p><p>Last seen: ";
            $days = floor((time() - $q["last_login"]) / (24 * 3600));
            if ($days > 0) {
                echo " " . $days;
                echo $days > 1 ? " days" : " day";
            } else {
                $hours = floor((time() - $q["last_login"]) / (3600));
                if ($hours > 0) {
                    echo " " . $hours;
                    echo $hours > 1 ? " hours" : " hour";
                } else {
                    $minutes = floor((time() - $q["last_login"]) / 60);
                    if ($minutes > 0) {
                        echo " " . $minutes;
                        echo $minutes > 1 ? " minutes" : " minute";
                    } else {
                        $seconds = floor(time() - $q["last_login"]);
                        echo " " . $seconds;
                        echo $seconds != 1 ? " seconds" : " second";
                    }
                }
            }
            echo " ago</p><p style='margin-bottom:0'>" . $q["username"] . "'s socks:</p>";
            $user_socks = getUserSocks($id_user, 1);
            if (is_int($user_socks) && $user_socks == 0) {
                echo "<p class='info'>This user doesn't have any socks. He/she is probably barefoot.</p>";
            } else {
                
                $per_page = 16;

                $count = mysqli_num_rows($user_socks);
                $num_pages = ceil($count / $per_page);
                
                $page = isset($_GET["page"]) && (int) $_GET["page"] > 0 && (int) $_GET["page"] <= $num_pages ? $_GET["page"] : 1;
                $user_socks_offset = getUserSocksOffset($id_user, $per_page, ($page - 1) * $per_page, 1);
                
                echo "<div class='user-content'>";
                while ($q = mysqli_fetch_array($user_socks_offset)) {
                    echo "<div class='user-content-item'><a href='socks.php?id=" . $q["id_socks"] . "'><div class='user-content-img' style='background-image:url(uploads/socks_images/".$q["image"].")'></div></a></div>";
                }
                echo "<div class='clear'></div></div>";
                
                if ($num_pages > 1) {
                    echo "<div class='pages'>";
                    for ($i = 0; $i < $num_pages; $i++) {
                        if ($page == $i + 1) {
                            echo "<a class='current' href='user.php?id=" . $id_user . "&page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
                        } else {
                            echo "<a href='user.php?id=" . $id_user . "&page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
                        }
                    }
                    echo "</div><div class='clear'></div>";
                }
            }
        }
    }
    ?>
</div>
</body>
</html>
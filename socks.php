<?php
@session_start();

include("query.php");
$page_title = "Rate my socks - Socks";
$css_files = array("socks");
include("header.php");

?>
<div class="main">
    <?php
    if (isset($_GET["id"])) {
        $id_socks = $_GET["id"];
        $socks = getSocksById($id_socks);
        
        if(isset($_POST["btnComment"]) && !empty($_POST["tbComment"])){
            addComment($_POST["tbComment"], $socks["id_socks"], $_SESSION["id_user"]);
        }
        
        if ((int) $socks == 0 || $socks["status"] != 1) {
            echo "<h2>Socks not found</h2><p class='info'>These socks don't exist!</p>";
        } else {
            $likes = getSocksLikes($q["id_socks"]);
            $like = "";
            $is_logged = " not-logged";
            if (isset($_SESSION["id_user"])) {
                $user_liked = hasUserLiked($socks["id_socks"], $_SESSION["id_user"]);
                //$like = "onclick='like_socks(".$q['id_socks'].")'";
                $is_logged = " like-logged";
            }
            ?>
            <div class="socks-left">
                <div class="inner-img" style="background-image:url('<?php echo "uploads/socks_images/" . $socks["image"]; ?>');"></div>
            </div>
            <div class="socks-right">
                <p>Posted by <a href="user.php?id=<?php echo $socks["id_owner"]; ?>"><?php echo $socks["username"]; ?></a> on <?php echo @date("M d Y", $socks["date_posted"]); ?></p>
                <p><?php echo $socks["description"]; ?></p>
                <?php
                $comments = getSocksComments($socks["id_socks"]);
                if (!is_int($comments)) {
                    echo "<div class='comments'>";
                    while ($comment = mysqli_fetch_array($comments)) {
                        $comment_user_id = $comment["id_user"];
                        echo "<div class='comment-box'><span class='comment-username'><a href='user.php?id=" . $comment_user_id . "'>" . $comment["username"] . "</a></span><span>" . $comment["comment"] . "</span></div>";
                    }
                    echo "</div>";
                }
                if (isset($_SESSION["id_user"])) {
                    ?>
                <form class="comment-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]."?id=".$_GET["id"]; ?>">
                    <textarea name="tbComment"></textarea>
                    <input type="submit" value="Comment" name="btnComment"/>
                </form>
                <?php
                }
                ?>
            </div>
            <div class="socks-info clear">
                <span class="socks-like<?php echo $is_logged; ?>"><i class="like-click fa fa-heart <?php
                    if (isset($user_liked) && $user_liked)
                        echo "socks-liked";
                    else
                        echo "socks-notliked";
                    ?>" <?php echo $like ?>></i><?php if($is_logged == " not-logged") echo "<div class='wishlist-notify'>You must be logged in to like!</div>"; ?><span id="socks-<?php echo $socks["id_socks"]; ?>" class="num-likes"><?php echo $socks["num_likes"]; ?></span></span>
            </div>

            <?php
        }
    }
    ?>
</div>
</body>
</html>
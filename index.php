<?php
@session_start();
include("query.php");
$page_title = "Rate my socks - Home";
$js_files = array("ajax", "imagesloaded.pkgd.min", "imageLoad");
include("header.php");
?>
<div class="main">
    <?php
    $order_by = isset($_GET["order_by"]) ? $_GET["order_by"] : "new";
    $order = $order_by == "popular" ? "num_likes DESC, date_posted" : "date_posted";
    $query_get_socks = mysqli_query($conn, "SELECT *, (SELECT COUNT(id_socks) FROM likes l WHERE l.id_socks=s.id_socks) as num_likes, (SELECT COUNT(id_socks) FROM comments c WHERE c.id_socks=s.id_socks) as num_comments FROM socks s JOIN users u ON s.id_owner=u.id_user WHERE s.status=1 ORDER BY $order DESC LIMIT 9");
    while ($q = mysqli_fetch_array($query_get_socks)) {
        $likes = getSocksLikes($q["id_socks"]);
        $like = "";
        $is_logged = " not-logged";
        if (isset($_SESSION["id_user"])) {
            $user_liked = hasUserLiked($q["id_socks"], $_SESSION["id_user"]);
            //$like = "onclick='like_socks(".$q['id_socks'].")'";
            $is_logged = " like-logged";
        }
        ?>
        <div class="socks">
            <div class="socks-img"><div class="image-overlay"><img src="images/loader2.gif" alt="Loading..."/></div><a href="socks.php?id=<?php echo $q["id_socks"]; ?>"><span class="inner-img" style="background-image:url('<?php echo "uploads/socks_images/" . $q["image"]; ?>');"></span></a></div>
            <div class="socks-info">
                <span class="socks-like<?php echo $is_logged; ?>"><i title="Like" class="like-click fa fa-heart <?php if (isset($user_liked) && $user_liked)
        echo "socks-liked";
    else
        echo "socks-notliked";
    ?>" <?php echo $like ?>></i><?php if ($is_logged == " not-logged") echo "<span class='wishlist-notify'>You must be logged in to like!</span>"; ?><span id="socks-<?php echo $q["id_socks"]; ?>" class="num-likes" title="Likes"><?php echo $q["num_likes"]; ?></span></span><a href="socks.php?id=<?php echo $q["id_socks"]; ?>" title="Comments" ><span class="comments-num"><i class="fa fa-comment-o"></i><?php echo $q["num_comments"]; ?></span></a><a class="socks-username" href="user.php?id=<?php echo $q["id_user"]; ?>"><?php echo $q["username"]; ?></a>
            </div>
        </div>
    <?php
}
?>

</div>
<div id="loader" class="loader"></div>
</body>
</html>
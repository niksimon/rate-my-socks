<?php
    @session_start();
    $page_title = "Rate my socks - News";
    $css_files = array("news");
    include("connection.php");
    include("header.php");
?>
    <div class="main">
        <h2>News</h2>
        <?php
            $page = isset($_GET["page"]) ? $_GET["page"] : 1;
            
            $query_select_all_news = mysqli_query($conn, "SELECT * FROM news n JOIN users u ON n.posted_by=u.id_user WHERE visible=1 ORDER BY date_posted DESC");
            $query_select_news = mysqli_query($conn, "SELECT * FROM news n JOIN users u ON n.posted_by=u.id_user WHERE visible=1 ORDER BY date_posted DESC LIMIT 3 OFFSET ".(($page - 1)*3));
            
            $count = mysqli_num_rows($query_select_all_news);
            $num_pages = ceil($count / 3);
            
            while($q = mysqli_fetch_array($query_select_news)){
                echo "<div class='news'>";
                echo "<h3>".$q["title"]."</h3>";
                echo "<p class='posted'>Posted by <a href='user.php?id=".$q["posted_by"]."'>".$q["username"]."</a> on ".date("d-m-Y H:i", $q["date_posted"])."</p>";
                echo "<p class='description'>".$q["description"]."</p>";
                echo "</div>";
            }
            echo "<div class='pages'>";
            for($i = 0; $i < $num_pages; $i++){
                if($page == $i + 1){
                    echo "<a class='current' href='news.php?page=".($i+1)."'>".($i + 1)."</a>";
                }
                else{
                    echo "<a href='news.php?page=".($i+1)."'>".($i + 1)."</a>";
                }
            }
            echo "</div>";
        ?>
    </div>
</script>
    </body>
</html>
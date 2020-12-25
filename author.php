<?php
@session_start();
$page_title = "Rate my socks - Author";
$css_files = array("author");
include("connection.php");
include("header.php");

?>
<div class="main">
    <h2>Author</h2>
    <img src="images/author.jpg" alt="Author"/>
    <p>Hello, my name is Nikola and this website is a project for PHP course at ICT college.</p>
    <p class="author-email">E-mail: <span>nikola.simonovic.9.14@ict.edu.rs</span></p>
    <form method="post" action="author.php">
        <div><p>Rate my website:</p></div>
        <?php
        if (isset($_POST["btnVote"]) && isset($_POST["rbPoll"])) {
            $vote_option = $_POST["rbPoll"];
            $query_get_vote = mysqli_query($conn, sprintf("SELECT votes FROM poll WHERE id_option=%d", $vote_option));
            $add_vote = mysqli_fetch_array($query_get_vote)["votes"] + 1;
            $query_add_vote = mysqli_query($conn, sprintf("UPDATE poll SET votes=%d WHERE id_option=%d", $add_vote, $vote_option));
        }

        $query_poll = mysqli_query($conn, "SELECT * FROM poll");
        $query_count = mysqli_query($conn, "SELECT SUM(votes) FROM poll");
        $count = mysqli_fetch_array($query_count)[0];
        while ($q = mysqli_fetch_array($query_poll)) {
            $percent = $count != 0 ? round(($q['votes'] / $count) * 100) : 0;
            echo "<div><label for='rb" . $q["id_option"] . "'>" . $q["option_name"] . "</label> <input id='rb" . $q["id_option"] . "' type='radio' value='" . $q["id_option"] . "' name='rbPoll'/>";
            $width = ($percent / 150) * 100;
            echo "<hr style='width: ".$width."px;margin:1px 10px 0 10px; display: inline-block; vertical-align: top; background-color: #7EA6F4;border: none;outline: none;height: 15px;'/><span>" . $percent . "%</span></div>";
        }
        ?>
        <div><input type='submit' value='VOTE' id='btnVote' name='btnVote'/></div>
    </form>
</div>
</body>
</html>
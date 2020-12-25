<?php

@session_start();
include("connection.php");
if (isset($_SESSION["id_user"])) {
    $id_socks = $_GET["id_socks"];
    $id_user = $_SESSION["id_user"];
    $query_check = mysqli_query($conn, sprintf("SELECT * FROM likes WHERE id_socks=%d AND id_user=%d", $id_socks, $id_user));
    if (mysqli_num_rows($query_check) == 0) {
        $query_add = mysqli_query($conn, sprintf("INSERT INTO likes (id_socks, id_user) VALUES(%d, %d)", $id_socks, $id_user));
    } else {
        $query_remove = mysqli_query($conn, sprintf("DELETE FROM likes WHERE id_socks=%d AND id_user=%d", $id_socks, $id_user));
    }
}
$query_likes = mysqli_query($conn, sprintf("SELECT COUNT(id_socks) FROM likes WHERE id_socks=%d", $id_socks));
if (mysqli_num_rows($query_likes) > 0)
    $like_count = mysqli_fetch_array($query_likes)[0];
else
    $like_count = 0;
echo $like_count;
?>
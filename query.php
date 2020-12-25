<?php
include("connection.php");

function getUser($id) {
    global $conn;
    $query_select_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user=" . $id);
    if (mysqli_num_rows($query_select_user) == 0) {
        return 0;
    }
    $user = mysqli_fetch_array($query_select_user);
    return $user;
}

function getUserSocks($id, $status = 0) {
    global $conn;
    if($status == 1){
        $query_select_socks = mysqli_query($conn, sprintf("SELECT * FROM socks WHERE id_owner=%d AND status=1 ORDER BY date_posted DESC", $id));
    }
    else{
        $query_select_socks = mysqli_query($conn, sprintf("SELECT * FROM socks WHERE id_owner=%d ORDER BY date_posted DESC", $id));
    }
    if (mysqli_num_rows($query_select_socks) == 0) {
        return 0;
    }
    return $query_select_socks;
}

function getUserSocksOffset($id, $limit, $offset, $status = 0) {
    global $conn;
    if($status == 1){
        $query_select_socks = mysqli_query($conn, sprintf("SELECT * FROM socks WHERE id_owner=%d AND status=1 ORDER BY date_posted DESC LIMIT %d OFFSET %d", $id, $limit, $offset));
    }
    else{
        $query_select_socks = mysqli_query($conn, sprintf("SELECT * FROM socks WHERE id_owner=%d ORDER BY date_posted DESC LIMIT %d OFFSET %d", $id, $limit, $offset));
    }
    if (mysqli_num_rows($query_select_socks) == 0) {
        return 0;
    }
    return $query_select_socks;
}

function deleteSocks($id_user, $id_socks) {
    global $conn;
    $query_delete_socks = mysqli_query($conn, sprintf("DELETE FROM socks WHERE id_owner=%d AND id_socks=%d", $id_user, $id_socks));
}

function getSocksLikes($id_socks) {
    global $conn;
    $query_get_likes = mysqli_query($conn, sprintf("SELECT COUNT(id_socks) FROM likes WHERE id_socks=%d", $id_socks));
    return mysqli_fetch_array($query_get_likes)[0];
}

function hasUserLiked($id_socks, $id_user) {
    global $conn;
    $query_get_like = mysqli_query($conn, sprintf("SELECT * FROM likes WHERE id_socks=%d AND id_user=%d", $id_socks, $id_user));
    if (mysqli_num_rows($query_get_like) == 0) {
        return false;
    }
    else {
        return true;
    }
}
function getSocksById($id){
    global $conn;
    $query_get_socks = mysqli_query($conn, sprintf("SELECT *, (SELECT COUNT(id_socks) FROM likes l WHERE l.id_socks=s.id_socks) as num_likes FROM socks s INNER JOIN users u ON s.id_owner=u.id_user WHERE id_socks=%d", $id));
    if(mysqli_num_rows($query_get_socks) == 0){
        return 0;
    }
    return mysqli_fetch_array($query_get_socks);
}
function getSocksComments($id_socks){
    global $conn;
    $query_get_comments = mysqli_query($conn, sprintf("SELECT * FROM comments c INNER JOIN socks s ON c.id_socks=s.id_socks INNER JOIN users u ON u.id_user=c.id_user WHERE c.id_socks=%d AND c.visible=1 ORDER BY c.date_posted ASC", $id_socks));
    if(mysqli_num_rows($query_get_comments) == 0){
        return 0;
    }
    return $query_get_comments;
}
function addComment($comment, $id_socks, $id_user){
    global $conn;
    $query_add_comment = mysqli_query($conn, sprintf("INSERT INTO comments(id_user, id_socks, comment, date_posted, visible) VALUES(%d, %d, '%s', %d, %d)", $id_user, $id_socks, $comment, time(), 1));
}
?>
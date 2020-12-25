<?php
@session_start();
include("connection.php");
if (isset($_GET["id_socks"]) && isset($_SESSION["id_user"])) {
    $id_socks = $_GET["id_socks"];
    $id_user = $_SESSION["id_user"];
    $query_select_status = mysqli_query($conn, sprintf("SELECT status FROM socks WHERE id_socks=%d AND id_owner=%d", $id_socks, $id_user));
    $status = mysqli_fetch_array($query_select_status, MYSQLI_ASSOC)["status"];
    switch ($status) {
        case 1:
            $status = 3;
            break;
        case 3:
            $status = 1;
            break;
    }
    $query_update_status = mysqli_query($conn, sprintf("UPDATE socks SET status=%d WHERE id_socks=%d AND id_owner=%d", $status, $id_socks, $id_user));
    @header("Location: account.php");
}
?>
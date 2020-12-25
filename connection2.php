<?php
    $conn = @mysqli_connect("localhost", "db", "pass", "user") or die("<div style='text-align: center; font-size: 20px; margin-top: 50px;'>Can't connect to server, please try again.</div>");
    @mysqli_set_charset($conn, "utf-8");
?>
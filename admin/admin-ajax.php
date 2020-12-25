<?php
    include("../connection.php");
    
    if(isset($_GET["id_menu"]) && isset($_GET["visible"])){
        $visible = $_GET["visible"] == 1 ? 0 : 1;
        $query_update_menu = mysqli_query($conn, sprintf("UPDATE menu SET visible=%d WHERE id_menu=%d", $visible, $_GET["id_menu"]));
        if($query_update_menu){
            echo "Updated!";
        }
        else{
            echo "Failed to write to database!";
        }
    }
    
    if(isset($_GET["id_comment"]) && isset($_GET["visible"])){
        $visible = $_GET["visible"] == 1 ? 0 : 1;
        $query_update_comment = mysqli_query($conn, sprintf("UPDATE comments SET visible=%d WHERE id_comment=%d", $visible, $_GET["id_comment"]));
        if($query_update_comment){
            echo "Updated!";
        }
        else{
            echo "Failed to write to database!";
        }
    }
    
    if(isset($_GET["id_news"]) && isset($_GET["visible"])){
        $visible = $_GET["visible"] == 1 ? 0 : 1;
        $query_update_news = mysqli_query($conn, sprintf("UPDATE news SET visible=%d WHERE id_news=%d", $visible, $_GET["id_news"]));
        if($query_update_news){
            echo "Updated!";
        }
        else{
            echo "Failed to write to database!";
        }
    }
?>
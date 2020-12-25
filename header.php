<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($page_title) ? $page_title : "Rate my socks"; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Nikola Simonović">
        <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : "A place to show off your new fancy socks!"?>">
        <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : "rate, my, socks, sock, rating, like, likes"?>">
        <meta name="robots" content="noindex, nofollow">
        <link rel="shortcut icon" href="images/favicon.png" type="image/png">
        <link href="css/main.css" rel="stylesheet" type="text/css">
        <?php
        if (isset($css_files)) {
            foreach ($css_files as $file) {
                echo "<link href='css/" . $file . ".css' rel='stylesheet' type='text/css'>\n";
            }
        }
        include("connection.php");
        $query_select_menu = mysqli_query($conn, "SELECT * FROM menu WHERE visible=1");
        ?>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed|Oswald" rel="stylesheet">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <?php
        if (isset($js_files)) {
            foreach ($js_files as $file) {
                echo "<script src='js/" . $file . ".js'></script>";
            }
        }
        ?>
    </head>
    <body>
        <div class="header">
            <span class="open-menu"></span>
            <span class="order"><a href="index.php?order_by=new">New</a><a href="index.php?order_by=popular">Most popular</a></span>
            <h1><a href="index.php">RATE MY SOCKS</a></h1>
            <?php if(isset($_SESSION["id_user"])) { ?>
            <a class="my-account" href="account.php"><i class="fa fa-user-o" aria-hidden="true"></i><span>My account</span></a>
            <?php } else { ?>
            <a class="log-in" href="login.php"><i class="fa fa-user-o" aria-hidden="true"></i><span>Log in</span></a>
            <?php } ?>
            <a class="add-socks" <?php if(!isset($_SESSION["id_user"])) echo "style='right:150px;'"; ?> href="add-socks.php"><i class="fa fa-plus" aria-hidden="true"></i><span class="add-text">Upload</span></a>
            <ul class="menu">
                <li class="mobile-visible"><i class="fa fa-star-o"></i><a href="index.php?order_by=new">New</a></li>
                <li class="mobile-visible"><i class="fa fa-fire"></i><a href="index.php?order_by=popular">Most popular</a></li>
                <?php
                while ($q = mysqli_fetch_array($query_select_menu)) {
                    echo "<li><i class='fa fa-" . $q["menu_icon"] . "'></i><a href='" . $q["menu_page"] . "'>" . $q["menu_name"] . "</a></li>";
                }
                ?>
            </ul>
        </div>
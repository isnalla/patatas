<?php
if(!isset($_SESSION))
    session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <?php //echo $_SESSION["page_title"] ?>
        <!-- put links here (css, jquery) -->
        <script src="/js/jquery.js"></script>
        <link rel="stylesheet" href="/css/reset.css"/>
        <link rel="stylesheet" href="/css/jquery.jui_dropdown.css"/>
        <link rel="stylesheet" href="/css/project.css"/>

        <script src="/js/jquery.jui_dropdown.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
    </head>
    <body>

    <div id="header">
        <div id="logo-container">
            <img src="/img/logo.png"/>
        </div>
        <div id="user-name">
            <?php echo $_SESSION['name']; ?>
        </div>
        <div id="user-options-container">
            <div id="user-options">
                <div id="option-trigger">
                </div>
            </div>
            <ul id="menu">
                <li id="opt_4.1"><a href="logout.php" id="logout" name="logout">Log out</a></li>
                <li id="opt_4.1"><a href="logout.php" id="logout" name="logout">Log out</a></li>
                <li id="opt_4.1"><a href="logout.php" id="logout" name="logout">Log out</a></li>
                <li id="opt_4.1"><a href="logout.php" id="logout" name="logout">Log out</a></li>
                <li id="opt_4.1"><a href="logout.php" id="logout" name="logout">Log out</a></li>
            </ul>
        </div>

    </div>



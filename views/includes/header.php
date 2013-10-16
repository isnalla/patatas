<?php
if(!isset($_SESSION))
    session_start();

echo $_SESSION["name"];?>

<!DOCTYPE html>
<html>
    <head>
        <?php //echo $_SESSION["page_title"] ?>
        <!-- put links here (css, jquery) -->
        <script src="/js/jquery.js"></script>
    </head>
    <body>


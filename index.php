<?php
    session_start();
    date_default_timezone_set('Asia/Yekaterinburg');

    require "dbconnect.php";
    require "header.php";
    
    echo '<main class="container" style="margin-top: 100px">';

    switch($_GET['page']) {
        case 'main': {
            require 'mainpage.php';
            break;
        };
        case 'account': {
            require 'accountpage.php';
            break;
        };
        case 'friends': {
            require 'friendspage.php';
            break;
        };
        default: {
            require 'mainpage.php';
            break;
        }
    }
    echo '</main>';

    echo $_SESSION['msg'];
    $_SESSION['msg'] = "";

    require "footer.php";


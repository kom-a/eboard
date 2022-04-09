<?php
    session_start();
    date_default_timezone_set('Asia/Yekaterinburg');
    require "dbconnect.php";
    require "header.php";

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

    echo $_SESSION['msg'];
    $_SESSION['msg'] = "";

    require "footer.php";


<?php
    session_start();
    date_default_timezone_set('Asia/Yekaterinburg');
    require "dbconnect.php";

    echo $_SESSION['msg'];
    $_SESSION['msg'] = "";

    if($_SESSION != null && $_SESSION['email'] != "") {
        echo "<p>Hello, " . $_SESSION['firstname'] . "!</p>";
        echo "<p><a href='auth.php?logout=1'>Выйти</a></p>";
    } else {
        echo "<form action='auth.php' method='post'>";
        echo "<p><input type='text' name='email' placeholder='email'></p>";
        echo "<p><input type='password' name='password' placeholder='password'></p>";
        echo "<p><input type='submit' value='Войти'></p>";
        echo "</form>";
    }




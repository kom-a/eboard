<?php
    session_start();
    require "header.php";
    require "dbconnect.php";

    echo '<main class="container" style="margin-top: 100px">';

    if($_SESSION == null || $_SESSION['email'] == "") {
        echo 'You are not logged in';
        exit();
    }

    if(!isset($_GET["id"])) {
        echo 'ID is not specified';
        exit();
    }

    try {
        $sql = 'DELETE FROM friends WHERE user_id=(:user_id) AND friend_id=(:friend_id) ';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('user_id', $_SESSION['user_id']);
        $stmt->bindValue('friend_id', $_GET['id']);
        $stmt->execute();
    } catch (PDOexception $error) {
        echo $error->getMessage();
        exit();
    }

    echo '</main>';
    header("Location: index.php?page=friends");
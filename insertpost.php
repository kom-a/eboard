<?php
    session_start();

    if(!isset($_POST['text'])
        or $_POST['text'] == ''
        or $_SESSION == null
        or $_SESSION['email'] == '') {

        header("Location: index.php");
        exit();
    }

    require "dbconnect.php";

    try {
        $sql = 'INSERT INTO posts(author_id, text) VALUES(:author_id, :text)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':author_id', $_SESSION['user_id']);
        $stmt->bindValue(':text', $_POST['text']);
        $stmt->execute();
        $_SESSION['msg'] = "Post added";

    } catch (PDOexception $error) {
        $_SESSION['msg'] = "Ошибка добавления категории: " . $error->getMessage();
    }

    header("Location: index.php");
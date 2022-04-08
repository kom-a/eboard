<?php
    session_start();
    require "dbconnect.php";

    if(!isset($_GET['id'])) {
        $_SESSION['msg'] = "Идентификатор не указан.";
        header('Location: index.php');
        exit();
    }

    try {
        $sql = 'SELECT * FROM posts WHERE post_id=:id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();

        if ($row=$stmt->fetch(PDO::FETCH_LAZY)) {
            if($row['author_id'] != $_SESSION['user_id']) {
                $_SESSION['msg'] = "Ошибка доступа.";
                header('Location: index.php');
                exit();
            }
        } else {
            $_SESSION['msg'] = "Ошибка получения информации о публикации.";
            header('Location: index.php');
            exit();
        }

        $sql = 'DELETE FROM posts WHERE post_id=:id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $_SESSION['msg'] = "Публикация удалена.";
    } catch (PDOexception $error) {
        $_SESSION['msg'] = "Ошибка удаления публикации: " . $error->getMessage();
    }
    // перенаправление на главную страницу приложения
    header('Location: index.php');
    exit();
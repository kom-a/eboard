<?php
    date_default_timezone_set('Asia/Yekaterinburg');
    require "dbconnect.php";

    try {
//        $sql = 'INSERT INTO category(name,id_user) VALUES(:name,:id_user)';
//        $stmt = $conn->prepare($sql);
        $conn->query('INSERT INTO users (email, md5_password, firstname, lastname) VALUES ("test@mail.ru", "my_password", "Kamil", "Kerimov")');
//        $stmt->bindValue(':name', $_GET['name']);
//        $stmt->bindValue(':id_user', $_SESSION['id']);
//        $stmt->execute();
        $_SESSION['msg'] = "Категория успешно добавлена";
        // return generated id
        // $id = $pdo->lastInsertId('id');

    } catch (PDOexception $error) {
        $_SESSION['msg'] = "Ошибка добавления категории: " . $error->getMessage();
        echo $error->getMessage();
    }
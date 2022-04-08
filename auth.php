<?php
    session_start();
    require "dbconnect.php";

    if (isset($_GET['logout'])) {
        $_SESSION['email'] = '';
        $_SESSION['msg'] =  "Вы успешно вышли из системы";
        header('Location: index.php');
        exit();
    }

    if (isset($_POST["email"]) and $_POST["email"]!='' and isset($_POST["password"]) and $_POST["password"]!='') {
        try {
            $sql = 'SELECT * FROM users WHERE email=(:email)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $_POST['email']);
            $stmt->execute();
        } catch (PDOexception $error) {
            $msg = "Ошибка аутентификации: " . $error->getMessage();
            exit();
        }

        if ($row=$stmt->fetch(PDO::FETCH_LAZY)) {
            if (MD5($_POST["password"])!= $row['md5_password'])
                $_SESSION['msg'] = "Неправильный пароль!";
            else {
                // successful auth
                $_SESSION['email'] = $row["email"];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['msg'] =  "Вы успешно вошли в систему";
            }
        } else
            $_SESSION['msg'] =  "Неправильное имя пользователя!";
    }

    header('Location: index.php');
?>
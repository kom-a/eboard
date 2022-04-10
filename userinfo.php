<?php
    if($conn == null)
        require "dbconnect.php";

    try {
        $sql = 'SELECT * FROM users WHERE user_id=(:user_id)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
        $stmt->execute();
    } catch (PDOexception $error) {
        echo $error->getMessage();
        exit();
    }

    if($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        echo '
        <h3>'.$row["firstname"] . ' ' . $row["lastname"].'</h3>
        <h5>Login: '.$row["email"].'</h5>
        <h5>Personal ID: '.$row["user_id"].'</h5>
        ';    
    }

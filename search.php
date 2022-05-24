<?php
    if($conn == null)
        require "dbconnect.php";

    require "header.php";

    echo '<main class="container" style="margin-top: 100px">';

    require "searchinput.php";

    if(isset($_GET["id"]) && $_GET["id"] != "") {
        try {
            $sql = 'SELECT * FROM users WHERE user_id=(:user_id) AND user_id != (:self_id)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':user_id', $_GET['id']);
            $stmt->bindValue(':self_id', $_SESSION['user_id']);
            $stmt->execute();
        } catch (PDOexception $error) {
            echo $error->getMessage();
            exit();
        }
    } else if(isset($_GET["firstname"]) || isset($_GET["lastname"])) {
        $firstname = isset($_GET["firstname"]) ? $_GET["firstname"] : '%';
        $lastname = isset($_GET["lastname"]) ? $_GET["lastname"] : '%';

        try {
            $sql = 'SELECT * FROM users WHERE firstname LIKE "%'.$firstname.'%" AND lastname LIKE "%'.$lastname.'%" AND user_id != (:self_id)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':self_id', $_SESSION['user_id']);
            $stmt->execute();
        } catch (PDOexception $error) {
            echo $error->getMessage();
            exit();
        }
    } else {
        echo 'No search information specified';
        exit();
    }

    echo '<h3>Результаты поиска:</h3>';
    while($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        echo '
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <img src="'. $row["avatarURL"] .'" alt="avatar" width="32" height="32" class=flex-shrink-0">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">'.$row['firstname'].' '.$row['lastname'].'</h6>
                        <p class="mb-0 opacity-75">'.$row['email'].'</p>
                    </div>
                    <a href="addfriend.php?id='.$row['user_id'].'" class="list-group-item">Добавить</a>
                </div>
            </div>
        ';
    }

    echo '</main>';
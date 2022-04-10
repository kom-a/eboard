<?php
    require "searchinput.php";

    if($conn == null)
        require "dbconnect.php";

    try {
        $sql = 'SELECT * FROM friends INNER JOIN users ON friends.friend_id=users.user_id WHERE friends.user_id=(:user_id)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
        $stmt->execute();
    } catch (PDOexception $error) {
        echo $error->getMessage();
        exit();
    }

    echo '<h4>Друзья: </h4>';
    while($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        echo '
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <img src="res/default_user.png" alt="avatar" width="32" height="32" class=flex-shrink-0">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0">'.$row['firstname'].' '.$row['lastname'].'</h6>
                        <p class="mb-0 opacity-75">'.$row['email'].'</p>
                    </div>
                    <a href="deletefriend.php?id='.$row['friend_id'].'" class="list-group-item">Удалить</a>
                </div>
            </div>
        ';
    }
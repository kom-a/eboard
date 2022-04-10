<?php
    if($_SESSION != null && $_SESSION['email'] != "") {
        require 'createpost.php';

        try {
            $sql_friends = 'SELECT * from friends WHERE user_id=(:user_id)';
            $stmt_friends = $conn->prepare($sql_friends);
            $stmt_friends->bindValue('user_id', $_SESSION["user_id"]);
            $stmt_friends->execute();

            $sql = 'SELECT * FROM posts INNER JOIN users ON author_id = user_id WHERE author_id=(:author_id)';

            while($row = $stmt_friends->fetch(PDO::FETCH_LAZY)) {
                $sql = $sql . " OR author_id=" . $row["friend_id"];
            }

            $sql = $sql . " ORDER BY created_at DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue('author_id', $_SESSION['user_id']);
            $stmt->execute();
        } catch (PDOexception $error) {
            echo $error->getMessage();
            exit();
        }

        echo '<ul class="list-group">';
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            echo '
                <li class="list-group-item">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <small class="opacity-50">'.$row["email"].'</small>
                        <div>
                        <small class="opacity-50">'.$row['created_at'].'</small>
                        ';
                        if($row["author_id"] == $_SESSION["user_id"]) {
                            echo '<a href="deletepost.php?id= ' . $row["post_id"] .'" class="opacity-60">Delete</a>';
                        }
                        echo '
                        </div>
                    </div>
                    <div>
                    '.$row["text"].'
                    
                    </div>
                </li>
            ';
        }
        echo '</ul>';
    } else {
        echo '<a class="nav-item">You are not logged in</a>';
    }
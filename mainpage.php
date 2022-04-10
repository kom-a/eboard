<?php
    require 'createpost.php';

    if($_SESSION != null && $_SESSION['email'] != "") {
        try {
            $sql = 'SELECT * FROM posts WHERE author_id=(:author_id)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':author_id', $_SESSION['user_id']);
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
                            <small class="opacity-50">'.$row['created_at'].'</small>
                    </div>
                    You: ' . $row["text"] . '
                    <a href="deletepost.php?id= ' . $row["post_id"] .'">Delete</a>
                </li>
                ';

            echo '
            ';
        }
        echo '</ul>';
    } else {
        echo '<a class="nav-item">You are not logged in</a>';
    }
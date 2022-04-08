<?php
    session_start();
    date_default_timezone_set('Asia/Yekaterinburg');
    require "dbconnect.php";
    require "header.php";

    require "createpost.php";

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
                  <li class="list-group-item">' . $row["created_at"]. ': ' . $row["text"] . '
                    <a href="deletepost.php?id= ' . $row["post_id"] .'"> Delete</a>
                  </li>
            ';
        }
        echo '</ul>';
    } else {
        echo '<a class="nav-item">You are not logged in</a>';
    }

//    echo '<ul class="list-group">
//  <li class="list-group-item">Cras justo odio</li>
//  <li class="list-group-item">Dapibus ac facilisis in</li>
//  <li class="list-group-item">Morbi leo risus</li>
//  <li class="list-group-item">Porta ac consectetur ac</li>
//  <li class="list-group-item">Vestibulum at eros</li>
//</ul>';


    echo $_SESSION['msg'];
    $_SESSION['msg'] = "";

    require "footer.php";


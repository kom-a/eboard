<?php
    if($_SESSION == null || $_SESSION['email'] == "") {
        echo '
            <div>
                You are not logged in;
            </div>
        ';

        exit();
    }

    echo '
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="res/default_user.png" class="img-fluid">
                    <div>
                        <button class="btn btn-dark justify-content-xl-center">Изменить аватар</button>
                    </div>
                </div>
               <div class="col">';
    require "userinfo.php";
    echo '
                </div>
            </div>
        </div>
    ';

    require "createpost.php";

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
<?php
use Aws\S3\S3Client;
use S3FileUploader\S3FileUploader;
use UploadService\UploadService;

    if($_SESSION == null || $_SESSION['email'] == "") {
        echo '
            <div>
                You are not logged in;
            </div>
        ';

        exit();
    }

    try {
        $sql = 'SELECT * FROM users WHERE user_id=(:user_id)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_LAZY);
    } catch (PDOexception $error) {
        echo $error->getMessage();
        exit();
    }

    echo '
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="' . $user["avatarURL"] . '" class="img-fluid" style="width: 500px; height: 400px;">
                    <div>
                        <form class="form-control" action="update_avatar.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="filename">
                            <input class="btn btn-outline-secondary" type="submit" value="Изменить аватар">
                        </form>
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
              <li class="list-group-item">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                            <small class="opacity-50">'.$row['created_at'].'</small>
                    </div>
                    '.$row["text"].'
                    <a href="deletepost.php?id= ' . $row["post_id"] .'">Delete</a>
                </li>
        ';
    }
    echo '</ul>';
?>
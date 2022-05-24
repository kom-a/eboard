<?php
require "dbconnect.php";

use Aws\S3\S3Client;

if(isset($_FILES['filename']))
{
    if ($file = fopen($_FILES['filename']['tmp_name'], 'r+')) {
        //получение расширения
        $ext = explode('.', $_FILES["filename"]["name"]);
        $ext = $ext[count($ext) - 1];
        $filename = 'file' . rand(100000, 999999) . '.' . $ext;

        $credentials = new Aws\Credentials\Credentials($_ENV['S3_KEY'], $_ENV['S3_SECRET']);
        $s3client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => $_ENV['S3_ENDPOINT'],
            'use_path_style_endpoint' => true,
            'credentials' => $credentials
        ]);

        $resource = $s3client->putObject([
            'Bucket' => $_ENV['S3_BUCKET'],
            'Key' =>  $_ENV['S3_KEY'] . '/' . $filename,
            'Body' => $file
        ]);

        $picture_url = $resource['ObjectURL'];
    }
    else {
        echo "Failed to open file";
        $picture_url = '/res/default_user.png';
    }

    $_SESSION['avatarURL'] = $picture_url;
    $sql = "UPDATE users SET `avatarURL`='$picture_url' WHERE `user_id`=:userId";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":userId", $_SESSION['user_id']);
    $stmt->debugDumpParams();
    $stmt->execute();

    header("Location: index.php?page=account");
}

Header("Location: index.php?page=account");

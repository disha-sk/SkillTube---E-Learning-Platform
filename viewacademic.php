<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Academic Videos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/stuacademicspic.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
        }
        .container {
            margin: 120px auto;
            width: 50%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.92);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Upload Academic Video</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Video Title:</label>
        <input type="text" name="title" required>

        <label>Select Video File:</label>
        <input type="file" name="video" accept="video/mp4, video/mkv, video/webm" required>

        <input type="submit" name="submit" value="Upload Video">
    </form>
</div>

</body>
</html>

<?php

$uploadDirectory = 'iwpvideos/';

// Create folder if not exists
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "iwpproject");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table if not exists
$createTable = "
CREATE TABLE IF NOT EXISTS educational_videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    video_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $createTable);

// Upload handling
if (isset($_POST["submit"])) {
    
    $title = $_POST["title"];
    $video = $_FILES["video"];

    if ($video["error"] === 4) {
        echo "<script>alert('Please select a video');</script>";
    } else {
        $videoName = $video["name"];
        $videoTmp = $video["tmp_name"];
        $videoSize = $video["size"];

        $validExtensions = ['mp4', 'mkv', 'webm'];
        $ext = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

        if (!in_array($ext, $validExtensions)) {
            echo "<script>alert('Invalid file type. Only MP4, MKV, WEBM allowed');</script>";
        } else if ($videoSize > 500000000) {
            echo "<script>alert('Video too large! Limit = 500MB');</script>";
        } else {

            $newVideoName = uniqid() . "." . $ext;

            if (move_uploaded_file($videoTmp, $uploadDirectory . $newVideoName)) {

                $insert = "INSERT INTO educational_videos (title, video_name)
                           VALUES ('$title', '$newVideoName')";

                if (mysqli_query($conn, $insert)) {
                    echo "<script>alert('Video uploaded successfully');</script>";
                } else {
                    echo "Database Error: " . mysqli_error($conn);
                }
            } else {
                echo "<script>alert('Error uploading video');</script>";
            }
        }
    }
}

mysqli_close($conn);
?>

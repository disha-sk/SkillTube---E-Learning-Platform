<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Academic Videos - Skill Tube</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('images/stuacademicspic.jpg'); 
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }
    .container {
        margin: 50px auto;
        width: 80%;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    h1 {
        text-align: center;
        margin-bottom: 40px;
    }
    .video-list {
        list-style: none;
        padding: 0;
    }
    .video-list-item {
        margin-bottom: 30px;
    }
    .video-wrapper {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Academic Videos</h1>
    <ul class="video-list">
        <?php
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "iwpproject");

        if (!$conn) {
            die("<li>Database connection failed: " . mysqli_connect_error() . "</li>");
        }

        // Fetch videos
        $sql = "SELECT video_name FROM educational_videos";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $videoName = htmlspecialchars($row['video_name']);
                $videoPath = "iwpvideos/" . $videoName;

                if(file_exists($videoPath)) {
                    echo "<li class='video-list-item'>
                            <div class='video-wrapper'>
                                <video class='video' controls>
                                    <source src='{$videoPath}' type='video/mp4'>
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                          </li>";
                } else {
                    echo "<li class='video-list-item'>Video file '{$videoName}' not found.</li>";
                }
            }
        } else {
            echo "<li>No academic videos available.</li>";
        }

        mysqli_close($conn);
        ?>
    </ul>
</div>
</body>
</html>

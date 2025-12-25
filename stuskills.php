<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/stuskillspic.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
        }
        .container {
            margin: 50px auto;
            width: 80%;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .video-list {
            list-style-type: none;
            padding: 0;
        }
        .video-list-item {
            margin-bottom: 10px;
        }
        .video-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            overflow: hidden;
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
        <h1>Skills Videos</h1>
        <ul class='video-list'>
            <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "iwpproject");

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch video names from the database
            $sql = "SELECT video_name, title FROM skills_videos";
            $result = mysqli_query($conn, $sql);

            // Check if the query was executed successfully
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Video name and title
                    $videoName = $row['video_name'];
                    $title = $row['title'];

                    // Output the video element
                    echo "<li class='video-list-item'>";
                    echo "<h3>$title</h3>";
                    echo "<div class='video-wrapper'>";
                    echo "<video class='video' controls>";
                    echo "<source src='iwpvideos/$videoName' type='video/mp4'>"; // Assuming all videos are in mp4 format
                    echo "Your browser does not support the video tag.";
                    echo "</video>";
                    echo "</div>";
                    echo "</li>";
                }
            } else {
                // No videos found in the database
                echo "<p>No skills videos available</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>

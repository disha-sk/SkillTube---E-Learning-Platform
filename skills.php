<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/skillspic.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
            margin: 0;
            padding: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 50%;
            padding: 20px;
            background-color: rgba(255,255,255,0.9); /* Adding transparency to the container */
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-top: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Skills Videos</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            <label for="video">Upload Video:</label>
            <input type="file" id="video" name="video" accept="video/mp4, video/mkv, video/webm" required>
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>

    <?php
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "iwpproject");

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Create skills_videos table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS skills_videos (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        video_name VARCHAR(255) NOT NULL,
        upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $sql)) {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }

    // Check if the form is submitted
    if (isset($_POST["submit"])) {
        $title = mysqli_real_escape_string($conn, $_POST["title"]); // Sanitize user input
        $description = mysqli_real_escape_string($conn, $_POST["description"]); // Sanitize user input

        // Check if video is uploaded
        if ($_FILES["video"]["error"] == 4) {
            echo "<script>alert('No video selected');</script>";
        } else {
            $videoName = $_FILES["video"]["name"];
            $videoSize = $_FILES["video"]["size"];
            $tmpName = $_FILES["video"]["tmp_name"];
            $validVideoExtensions = ['mp4', 'mkv', 'webm'];
            $videoExtension = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

            // Check if video extension is valid
            if (!in_array($videoExtension, $validVideoExtensions)) {
                echo "<script>alert('Invalid video extension');</script>";
            }
            // Check if video size is within limit (100MB)
            elseif ($videoSize > 100000000) {
                echo "<script>alert('Video size is too large');</script>";
            } else {
                $newVideoName = uniqid() . '.' . $videoExtension;
                move_uploaded_file($tmpName, 'iwpvideos/' . $newVideoName); // Changed upload directory

                // Insert video details into database
                $query = "INSERT INTO skills_videos (title, description, video_name) VALUES ('$title', '$description', '$newVideoName')";
                if (mysqli_query($conn, $query)) {
                    echo "<script>alert('Video uploaded successfully');</script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }
            }
        }
    }

    // Close connection
    mysqli_close($conn);
    ?>
</body>
</html>

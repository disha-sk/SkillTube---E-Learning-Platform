<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/resourcespic.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
        }
        .container {
            margin: 150px auto;
            width: 50%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Adding transparency to the container */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <h1> Upload Resources/Articles</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            <label for="file">Upload File:</label>
            <input type="file" id="file" name="file" accept=".pdf, .doc, .docx, .txt" required>
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
</body>
</html>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "iwpproject");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS resources_articles (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $sql)) {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Check if the form is submitted
if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];

    // Check if file is uploaded
    if ($_FILES["file"]["error"] == 4) {
        echo "<script>alert('No file selected');</script>";
    } else {
        $fileName = $_FILES["file"]["name"];
        $fileSize = $_FILES["file"]["size"];
        $tmpName = $_FILES["file"]["tmp_name"];
        $validFileExtensions = ['pdf', 'doc', 'docx', 'txt'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if file extension is valid
        if (!in_array($fileExtension, $validFileExtensions)) {
            echo "<script>alert('Invalid file extension');</script>";
        }
        // Check if file size is within limit (10MB)
        elseif ($fileSize > 10000000) {
            echo "<script>alert('File size is too large');</script>";
        } else {
            // Store the file in the 'iwpfiles' folder
            $newFileName = uniqid() . '.' . $fileExtension;
            move_uploaded_file($tmpName, 'iwpfiles/' . $newFileName);

            // Insert file details into database
            $query = "INSERT INTO resources_articles (title, description, file_name) VALUES ('$title', '$description', '$newFileName')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('File uploaded successfully');</script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
}

// Close connection
mysqli_close($conn);
?>

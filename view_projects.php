<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project Ideas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: aquamarine;
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
        .project-list {
            list-style-type: none;
            padding: 0;
        }
        .project-list-item {
            margin-bottom: 10px;
        }
        .file-embed {
            width: 100%;
            height: 600px; /* Set the height as desired */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Project Ideas</h1>
        <ul class="project-list">
            <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "iwpproject");

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch project ideas from the database
            $sql = "SELECT * FROM project_ideas";
            $result = mysqli_query($conn, $sql);

            // Check if the query was executed successfully
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Project title and file name
                    $title = $row['title'];
                    $fileName = $row['file_name'];

                    // Output the project idea with a link to view the file
                    echo "<li class='project-list-item'>";
                    echo "<h3>$title</h3>";
                    echo "<iframe class='file-embed' src='iwpfiles/$fileName'></iframe>";
                    echo "</li>";
                }
            } else {
                // No project ideas found in the database
                echo "<p>No project ideas available</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>

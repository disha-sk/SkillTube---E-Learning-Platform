<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/sturesourcespic.jpg');
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
        .resource-list {
            list-style-type: none;
            padding: 0;
        }
        .resource-list-item {
            margin-bottom: 10px;
        }
        .resource-link {
            text-decoration: none;
            color: #333;
            cursor: pointer;
            display: block;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .resource-link:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resources/Articles</h1>
        <ul class='resource-list'>
            <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "iwpproject");

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch resources/articles uploaded from database
            $sql = "SELECT file_name, title FROM resources_articles";
            $result = mysqli_query($conn, $sql);

            // Check if the query was executed successfully
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // File name and title
                    $fileName = $row['file_name'];
                    $title = $row['title'];

                    // Output the resource/article link
                    echo "<li class='resource-list-item'>";
                    echo "<a class='resource-link' href='iwpfiles/$fileName' target='_blank'>$title</a>";
                    echo "</li>";
                }
            } else {
                // No resources/articles found in the database
                echo "<p>No resources/articles available</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Tube - Learning Made Easier</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Header Section -->
    <header>
        <div id="menu" class="fas fa-bars"></div>

        <a href="#" class="logo">
            <img src="images/logo.jpg" alt="Skill Tube Logo">
        </a>

        <nav class="navbar">
            <ul>
                <li><a class="active" href="#home">home</a></li>
                <li><a href="#about">about</a></li>
                <li><a href="#course">course</a></li>
                <li><a href="#teacher">teacher</a></li>
            </ul>
        </nav>

        <div id="login" class="fas fa-user-circle fa-3x"></div>
    </header>

    <!-- Login Form -->
    <div class="login-form">
        <form action="login.php" method="post">
            <h3>Login</h3>

            <input type="email" name="email" placeholder="username" class="box" required>
            <input type="password" name="password" placeholder="password" class="box" required>

            <p>forgot password? <a href="#">click here</a></p>
            <p>don't have an account? <a href="registration.php">register now</a></p>

            <input type="submit" class="btn" value="login">

            <i class="fas fa-times"></i>
        </form>
    </div>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="text-container">
            <a href="#" class="logohome">
                <img src="images/logo.jpg" alt="Skill Tube Logo">
            </a>

            <h1>Skill Tube</h1>
            <h3>Learning made easier</h3>

            <p>
                Unleash your engineering potential in our vibrant community. Access learning resources,
                connect with peers, and dive into collaborative opportunities. Join us and elevate your skills today!
            </p>

            <a href="registration.php">
                <button class="btn">Get Started</button>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="image">
            <img src="images/aboutimage.jpg" alt="About us">
        </div>

        <div class="content">
            <h3>why choose us?</h3>

            <p>
                Join us at Skill Tube for a comprehensive learning experience tailored to engineering students
                and teachers. Benefit from integrated academic learning and practical skills development through
                short videos, articles, and tutorials.
            </p>

            <a href="#">
                <button class="btn">learn more</button>
            </a>
        </div>
    </section>

    <!-- Course Section -->
    <section class="course" id="course">
        <div class="content">
            <center>
                <h1 class="heading">What all can you learn from our community?</h1>

                <div class="text">
                    <p>
                        Explore our comprehensive range of courses designed to enhance your skills and knowledge.
                    </p>

                    <img src="images/course.jpg" alt="Courses">

                    <p><b>Foundational Concepts:</b> Build a solid understanding of basic engineering principles.</p>

                    <img src="images/foundation.jpg" alt="Foundation">

                    <p><b>Specialized Topics:</b> Mechanical, Electrical, Civil, CS and more.</p>

                    <img src="images/specialized.jpg" alt="Specialized">

                    <p><b>Practical Skills:</b> Hands-on real-world projects and applications.</p>

                    <img src="images/practical.jpg" alt="Practical">

                    <p><b>Cutting-Edge Technologies:</b> AI, Robotics, Renewable Energy, and more.</p>
                </div>
            </center>
        </div>
    </section>

    <!-- Teacher Section -->
    <section class="teacher" id="teacher">
        <h1 class="heading">How Teachers Shape Our Community</h1>

        <img src="images/teacher.jpg" alt="Teacher">

        <p>
            Teachers contribute engaging video lectures, tutorials, quizzes, and learning materials.
            They also conduct webinars, workshops, and guest lectures to enrich the student experience.
        </p>

        <center>
            <a href="#">
                <button class="btn">learn more</button>
            </a>
        </center>
    </section>

    <!-- Footer Section -->
    <div class="footer">
        <h1 class="credit">created by Disha , Hiba , Harshini.</h1>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>

</body>
</html>

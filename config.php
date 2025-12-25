<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "iwpproject";

$link = new mysqli($servername, $username, $password, $dbname);

if ($link->connect_error) {
    die("Database connection failed: " . $link->connect_error);
}

$link->set_charset("utf8mb4"); // Better UTF-8
?>

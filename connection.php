<?php
// Database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

// Creating the connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


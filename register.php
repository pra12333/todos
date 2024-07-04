<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="register.php" method="POST">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

<?php
// Include the connection to the database
include 'connection.php';
session_start();

if (isset($_POST['register'])) {
    // Check if the form fields are set
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            // Set session variables
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            // Redirect to todo.php
            header('Location: todo.php');
            exit();
        } else {
            echo "ERROR: Could not execute query: " . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    } else {
        echo "<h2>Please fill in all fields</h2>";
    }
}
?>

</body>
</html>

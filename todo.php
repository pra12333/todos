<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <style>
        .task-list {
            margin-top: 20px;
        }
        .task-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .delete {
            color: red;
            text-decoration: none;
            float: right;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Todo List</h2>

    <?php
    session_start();
    include 'connection.php';

    // Check if user is logged in
    if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
        header('Location: register.php');
        exit();
    }

    echo "<h3>Welcome, " . $_SESSION['name'] . "</h3>";
    ?>

    <form method="post" action="todo.php" class="input_form">
        <input type="text" name="task" class="task_input" placeholder="Enter a new task">
        <button type="submit" name="submit" id="add_btn" class="add_btn">Add task</button>
        <?php if (isset($errors)) { ?>
            <p class="error"><?php echo $errors; ?></p>
        <?php } ?>
    </form>

<?php
// Initialize error variable
$errors = '';

// Insert the task if the form is submitted
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = "Please enter the task"; // Set error message
    } else {
        $task = mysqli_real_escape_string($conn, $_POST['task']);
        $email = $_SESSION['email'];

        // Fetch user ID and name
        $result = mysqli_query($conn, "SELECT id, name FROM users WHERE email='$email'");
        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $userid = $user['id'];
            $name = $user['name'];

            // Insert task
            $sql = "INSERT INTO todo (userid, name, task) VALUES ('$userid', '$name', '$task')";

            if (mysqli_query($conn, $sql)) {
                header('Location: todo.php');
                exit();
            } else {
                echo "ERROR: Could not execute query: " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: User not found or multiple users found with the same email.";
        }
    }
}

// Fetch the tasks
$email = $_SESSION['email'];
$result = mysqli_query($conn, "SELECT todo.id, todo.task FROM todo INNER JOIN users ON todo.userid = users.id WHERE users.email = '$email'");

?>

<div class="task-list">
    <h3>Task List</h3>
    <?php 
    if ($result) {
        $i = 1; 
        while ($row = mysqli_fetch_array($result)) { 
    ?>
        <div class="task-item">
            <?php echo $i; ?>. <?php echo htmlspecialchars($row['task']); ?>
            <span class="delete">
                <a href="todo.php?del_task=<?php echo $row['id'] ?>">x</a>
            </span>
        </div>
    <?php 
            $i++; 
        }
    } else {
        echo "ERROR: Could not fetch tasks: " . mysqli_error($conn);
    }
    ?>
</div>

<?php
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    if (mysqli_query($conn, "DELETE FROM todo WHERE id=$id")) {
        header('Location: todo.php');
        exit();
    } else {
        echo "ERROR: Could not delete task: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
        <form action="todo.php" method="POST">
        <h2>todo app </h2>
        name:<input type="text" name="name"><br>
        email:<input type="text" name="email"><br>
        <input type="submit" value="login">
    </form>
    <?php
    //connection to the database
  include 'connection.php';
  $sql = "SELECT * FROM users WHERE email='email'";
  $result = mysqli_query($conn,$sql);
  $user =mysqli_fetch_assoc($result);

  mysqli_close($conn);
  ?>

</body>
</html>
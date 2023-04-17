<?php
require('connect.php');
session_start();

if(!empty($_POST['name']) && !empty($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE name = :name";
    $statement = $db->prepare($query);
    $statement->bindValue(":name", $name);
    $statement->execute();

    $user = $statement->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; 
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login - Winnipeg Telecom</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Winnipeg Telecom</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </nav>
    <main>
        <h2>Login</h2>
        <?php if(isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Name:</label>
            <input type="text" name="name" id="name">
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <br>
            <input type="submit" value="Login">
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Winnipeg Telecom. All rights are sold separately.</p>
    </footer>
</body>
</html>

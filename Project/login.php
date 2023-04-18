<?php
require('connect.php');
session_start();

if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE email = :email";
    $statement = $db->prepare($query);
    $statement->bindValue(":email", $email);
    $statement->execute();

    $user = $statement->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; 
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

// add test
// Only admins can perform admin page CUD tasks.

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
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
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
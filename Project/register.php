<?php
require('connect.php');
session_start();


$errorMsg = '';

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name)) {
        $errorMsg = 'Name is required';
    } elseif (empty($email)) {
        $errorMsg = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Invalid email format';
    
    } elseif (empty($password)) {
        $errorMsg = 'Password is required';
    } elseif ($password != $confirm_password) {
        $errorMsg = 'Passwords do not match';

    } else {
        // Check if email already exists in the database
        $query = "SELECT * FROM Users WHERE email = :email LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch();
    
        if ($result) {
            $errorMsg = "This email address is already registered. Please log in or use a different email address.";
        } else {
            // Hash the password before saving it to the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Save the user to the database
            $query = "INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(":name", $name);
            $statement->bindValue(":email", $email);
            $statement->bindValue(":password", $hashed_password);
            $statement->execute();
    
            // Set session variables and redirect to homepage
            $_SESSION['user'] = ['name' => $name];
            header('Location: index.php');
            exit();
        }
    }
}
    
    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>User Registration</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
    <header>
            <h1>User Registration</h1>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
        <main>
            <form name="registrationForm" method="post">
    
            <label for="name">Name:</label>
            <input type="name" id="name" name="name"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password"><br>
    
            <?php if (!empty($errorMsg)) { ?>
                <p class="error"><?= $errorMsg; ?></p>
            <?php } ?>
    
                <input type="submit" value="Submit">
            </form>
        </main>
        <footer>
            <p>&copy; 2023 Winnipeg Telecom. All rights are sold separately.</p>
        </footer>
    </body>
    </html>
    
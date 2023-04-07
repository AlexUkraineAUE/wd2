<?php
require('connect.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();


$username = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
  $stmt = $db->prepare("SELECT * FROM login WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetchAll();
  
  if ($user && password_verify($password, $user[0]['password'])) {
      $_SESSION['username'] = $user[0]['username'];
      header("location: index.php");
  } else {
      $error = "Your Login Name or Password is invalid";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles_login.css">
</head>
<nav>
    <ul>
        <?php foreach ($menuItems as $menuItem): ?>
            <li><a href="<?=$menuItem['url']?>"><?=$menuItem['title']?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>    
</body>
</html>

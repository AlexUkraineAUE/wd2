<?php
require('connect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$msg = '';

$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();

if (isset($_POST['input']) && strlen($_POST['input']) > 0) {


    if ($_POST['input'] == $_SESSION['captcha']) {
        $yourName = $_POST['your_name'];
        $employeeName = $_POST['employee_name'];
        $comment = $_POST['comment'];

        $query = "INSERT INTO Feedback (your_name, employee_name, comment) VALUES (:yourName, :employeeName, :comment)";
        $statement = $db->prepare($query);
        $statement->bindValue(":yourName", $yourName);
        $statement->bindValue(":employeeName", $employeeName);
        $statement->bindValue(":comment", $comment);
        $statement->execute();
        $_SESSION['captcha'] = null; 
        header("Location: feedback.php"); 
        exit;
    } else {
        $msg = "Captcha failed. Please try again.";
    }
}

$query = "SELECT * FROM Feedback WHERE visible = 1 ORDER BY id DESC";
$statement = $db->prepare($query);
$statement->execute();
$rows = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Winnipeg Telecom - Feedback</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Winnipeg Telecom</h1>
    </header>
    <nav>
    <ul>
            <?php foreach ($menuItems as $menuItem): ?>
                <li><a href="<?=$menuItem['url']?>"><?=$menuItem['title']?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <main>
        <h2>Feedback</h2>
        <p>Please leave your feedback for the employee below:</p>
        <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
            <label for="your_name">Your Name:</label>
            <input type="text" id="your_name" name="your_name" value="<?= isset($_POST['your_name']) ? $_POST['your_name'] : ''; ?>" required>

            <label for="employee_name">Employee Name:</label>
            <input type="text" id="employee_name" name="employee_name" value="<?= isset($_POST['employee_name']) ? $_POST['employee_name'] : ''; ?>" required>

            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" required><?= isset($_POST['comment']) ? $_POST['comment'] : ''; ?></textarea>

            <label for="input">Captcha:</label>
            <input type="text" name="input"/>
             <input type="submit" value="Submit Feedback" name="submit"/>
        </form>



            <h2>PROVE THAT YOU ARE NOT A ROBOT!!</h2>

            <strong>
                Type the text in the image to prove you are not a robot
            </strong>

            <div >
                <img src="captcha.php">
            </div>

            
         </form>
      
  

     <div style='margin-bottom:5px'>
        <?php echo $msg; ?>
    </div>

        

        <h3>Feedback Comments</h3>
<ul>
    <?php foreach ($rows as $row): ?>
        <div>
            <li>
                <?= "Posted by: " . $row['your_name'] ?> 
               <?="Team member:" . $row['employee_name'] ?>
                <?="Comment: " .  $row['comment'] ?>
                <a href="edit_feedback.php?id=<?= $row['id'] ?>">Edit</a>
            </li>
        </div>
    <?php endforeach; ?>
</ul>

    </main>
    <footer>
        <p>&copy; 2023 Winnipeg Telecom. All rights are sold separately.</p>
    </footer>
</body>
</html>
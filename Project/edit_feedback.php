<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('connect.php');
require('authenticate.php');


$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();


$query = "SELECT * FROM Feedback WHERE visible = 1 ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$rows = $statement->fetchAll();


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $employee_name = $_POST['employee_name'];
    $your_name = $_POST['your_name'];
    $comment = $_POST['comment'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    $query = "UPDATE Feedback SET employee_name = :employee_name, your_name = :your_name, comment = :comment, visible = :visible WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":employee_name", $employee_name);
    $statement->bindValue(":your_name", $your_name);
    $statement->bindValue(":comment", $comment);
    $statement->bindValue(":visible", $visible, PDO::PARAM_INT);
    $statement->bindValue(":id", $id);
    $statement->execute();

    header("Location: feedback.php?id=$id");
    exit();
}

if (isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM Feedback WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    header("Location: feedback.php");
    exit;
}

if (isset($_GET['id'])) {
    $query = "SELECT * FROM Feedback WHERE id = :id LIMIT 1";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $_GET['id']);
    $statement->execute();

    $row = $statement->fetch();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Winnipeg Telecom - Edit Comment</title>
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
        <h2>Edit Comment</h2>
        <form method="post" action="edit_feedback.php">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" id="employee_name" value="<?= $row['employee_name']?>">
            <label for="your_name">Your Name:</label>
            <input type="text" name="your_name" id="your_name" value="<?= $row['your_name']?>">
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment"><?= $row['comment']?></textarea>
            <input type="submit" name="submit" value="Save">
            <input type="submit" name="delete" value="Delete">
            <label for="visible">Visible:</label>
            <input type="checkbox" name="visible" id="visible" <?= $row['visible'] ? 'checked' : '' ?>>
        </form>
    </main>
    <footer>
        <p>&copy;</p>
   

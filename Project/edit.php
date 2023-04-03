<?php
require('connect.php');
require('authenticate.php');


$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $employee_name = $_POST['employee_name'];
    $service_history = $_POST['service_history'];
    $contact = $_POST['contact'];

    $query = "UPDATE Customer SET employee_name = :employee_name, service_history = :service_history, contact = :contact WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":employee_name", $employee_name);
    $statement->bindValue(":service_history", $service_history);
    $statement->bindValue(":contact", $contact);
    $statement->bindValue(":id", $id);
    $statement->execute();

    header("Location: index.php?id=$id");
    exit();
}

if (isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM Customer WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $query = "SELECT * FROM Customer WHERE id = :id LIMIT 1";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $_GET['id']);
    $statement->execute();

    $row = $statement->fetch();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Winnipeg Telecom - Edit Customer</title>
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
        <h2>Edit Customer</h2>
        <form method="post" action="edit.php">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" id="employee_name" value="<?= $row['employee_name'] ?>">
            <label for="service_history">Service History:</label>
            <textarea name="service_history" id="service_history"><?= $row['service_history'] ?></textarea>
            <label for="contact">Contact:</label>
            <textarea name="contact" id="contact"><?= $row['contact'] ?></textarea>
            <input type="submit" name="submit" value="Save">
            <input type="submit" name="delete" value="Delete">
        </form>
    </main>
    <footer>
        <p>&copy

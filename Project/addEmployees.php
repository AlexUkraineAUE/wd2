<?php
require('connect.php');
require('authenticate.php');

if ($_POST) {
    $employee_name = filter_input(INPUT_POST, 'employee_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $service_history = filter_input(INPUT_POST, 'service_history', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    
    $query = "INSERT INTO  Customer (employee_name, service_history, contact) VALUES (:employee_name, :service_history,  :contact)";
    $statement = $db->prepare($query);
    $statement->bindValue(":employee_name", $employee_name);
    $statement->bindValue(":service_history", $service_history);
    $statement->bindValue(":contact", $contact);
    if ($statement->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Winnipeg Telecom</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Winnipeg Telecom</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Equipment</a></li>
            <li><a href="about.php">Invoices</a></li>
            <li><a href="contact.php">Users</a></li>
            <li><a href="contact.php">Work orders</a></li>
        </ul>
    </nav>
    <main>
        <h2>Add new member</h2>
        <form method="post">
            <label for="employee_name">Employee name:</label>
            <input type="text" id="employee_name" name="employee_name">

            <label for="service_history">Service history:</label>
            <input type="text" id="service_history" name="service_history">

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact">

            <input type="submit" value="Add member">
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Winnipeg Telecom. All rights are sold separately.</p>
    </footer>
</body>
</html>

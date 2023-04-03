<?php
require('connect.php');

// Retrieve all content items from the database
$query = "SELECT id, title, url FROM content";
$statement = $db->prepare($query);
$statement->execute();
$rows = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
</head>
<body>
    <header>
        <h1>My Website</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php foreach ($rows as $row): ?>
                <li><a href="<?= $row['url'] ?>?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></li>
            <?php endforeach; ?>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <main>
        <?php
        // If an ID parameter is present in the URL, retrieve the corresponding content item from the database
        if (isset($_GET['id'])) {
            $query = "SELECT * FROM content WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindValue(":id", $_GET['id']);
            $statement->execute();

            $row = $statement->fetch();
            if ($row) {
                // Display the content item
                echo "<h2>{$row['title']}</h2>";
                echo "<p>{$row['content']}</p>";
            } else {
                // If no matching content item is found, display an error message
                echo "<p>Content not found.</p>";
            }
        } else {
            // If no ID parameter is present in the URL, display the home page
            echo "<h2>Welcome to my website</h2>";
            echo "<p>This is the home page. Please select a link from the navigation menu to view a specific content item.</p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2023 My Website. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
require('connect.php');

$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();

if(isset($_GET['id'])) {
    $query = "SELECT * FROM Customer WHERE id = :id LIMIT 1";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $_GET['id']);
    $statement->execute();

    $rows = $statement->fetchAll();
} else {
    $query = "SELECT * FROM Customer ORDER BY id DESC";
    $statement = $db->prepare($query);
    $statement->execute();

    $rows = $statement->fetchAll();
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
            <?php foreach ($menuItems as $menuItem): ?>
                <li><a href="<?=$menuItem['url']?>"><?=$menuItem['title']?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <main>
        <h2>Welcome to Winnipeg Telecom</h2>
        <p>We are a locally owned business that specializes in network installation services for businesses, schools, and other organizations. With our experienced team of technicians and growing client base, we provide efficient and reliable services for all your network installation needs.</p>
             
        <div class="customer-list">
            <table>
                <tr>
                    <th>Meet with our team</th>                
                </tr>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <a href="index.php?id=<?=$row['id']?>"><?= $row['employee_name'] ?></a> 
                        </td> 
                    </tr>
                    <?php if (isset($_GET['id']) && $row['id'] == $_GET['id']): ?>
                        <tr>
                            <td><?= $row['service_history'] ?></td>
                            <td><?= $row['contact'] ?></td>
                            <td><a href="edit.php?id=<?=$_GET['id']?>">Edit</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>              
            </table>
            <a href="feedback.php?id=<?=$row['id']?>">Leave feedback about our team</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Winnipeg Telecom. All rights are sold separately.</p>
    </footer>
</body>
</html>
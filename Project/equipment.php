<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connect.php');

$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();

$query = "SELECT * FROM Equipment ORDER BY item_ID ASC";
$statement = $db->prepare($query);
$statement->execute();

$rows = $statement->fetchAll();

$errors = [];
if($_POST) {
    
    $quantity = $_POST['quantity'];
    $name = $_POST['name'];

    if (empty($quantity)) {
        $errors[] = "Quantity is required";
    } 

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($errors)) {
        $query = "INSERT INTO Equipment (quantity, name) VALUES (:quantity, :name)";
        $statement = $db->prepare($query);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":quantity", $quantity, PDO::PARAM_INT);

        $statement->execute();
    
        header("Location: equipment.php"); 
    }
}


function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    $full_path = join(DIRECTORY_SEPARATOR, $path_segments);
    error_log("Full path: " . $full_path);
    return $full_path;
 }

 $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0) && !empty($_FILES['image']['name']);

 if ($image_upload_detected) {
    $image_filename       = $_FILES['image']['name'];
    $temporary_image_path = $_FILES['image']['tmp_name'];
    $new_image_path       = file_upload_path($_POST['name'] . '.jpg');

    error_log("Temporary path: " . $temporary_image_path);
    error_log("New path: " . $new_image_path);

    

         move_uploaded_file($temporary_image_path, $new_image_path);

         $query = "UPDATE Equipment SET image = 1 WHERE name = :name";
        $statement = $db->prepare($query);
        $statement->bindValue(":name", $name);
        $statement->execute();
   
}

 elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Equipment List</title>
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


    <h2>Add Equipment</h2>


    <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
    <?php endif; ?>

    <form method="post"  enctype="multipart/form-data">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity"><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image"><br> 

        <input type="submit" name="submit" value="Add Equipment">

        
    </form>

    <?php if (isset($_FILES['image']) && $_FILES['image']['error'] > 0): ?>

    <p>Error Number: <?= $_FILES['image']['error'] ?></p>

    <?php elseif (isset($_FILES['image'])): ?>

    <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
    <p>Apparent Mime Type:   <?= $_FILES['image']['type'] ?></p>
    <p>Size in Bytes:        <?= $_FILES['image']['size'] ?></p>
    <p>Temporary Path:       <?= $_FILES['image']['tmp_name'] ?></p>
    <p>Current location:      <?=$new_image_path ?></p>

    <?php endif ?>
    <h1>Equipment List</h1>
    <table class="equipment-table">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Name</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row['item_ID'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['name'] ?></td>
                <?php if (file_exists('uploads/' . $row['name'] . '.jpg')): ?>
                    <td><img src="uploads/<?= $row['name'] ?>.jpg" alt="<?= $row['name'] ?>"></td>
                <?php else: ?>
                    <td>No image available</td>
                <?php endif; ?>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
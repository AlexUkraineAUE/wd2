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
    } else if (!is_numeric($quantity)) {
        $errors[] = "Quantity must be a number";
    }

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($errors)) {
        $query = "INSERT INTO Equipment (quantity, name) VALUES (:quantity, :name)";
        $statement = $db->prepare($query);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":quantity", $quantity, PDO::PARAM_INT);
        if ($statement->execute()) {
            echo "<p>File uploaded successfully at: $new_image_path</p>";
            header("Location: equipment.php");
            exit;
        } else {
            echo "Error";
        }
    }
}



function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = getcwd(); 
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}


function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];

    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;       
}

$image_upload_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] === 0);
$upload_error_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] > 0);


if ($image_upload_detected) { 
    $filename  = $_FILES['uploaded_file']['name'];
    $temporary_image_path  = $_FILES['uploaded_file']['tmp_name'];
    $new_image_path    = file_upload_path($filename, 'uploads');
    $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);

    if (file_is_an_image($temporary_image_path, $new_image_path)) {

        if (move_uploaded_file($temporary_image_path, $new_image_path)) {
            echo "<p>File uploaded successfully at: $new_image_path</p>";
        } else {
            echo "<p>Error uploading file.</p>";
        }
    }      
} 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Equipment List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

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

<body>

    <h2>Add Equipment</h2>

    <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
    <?php endif; ?>

    <?php if ($upload_error_detected): ?>
        <p>Error Number: <?= $_FILES['uploaded_file']['error'] ?></p>
    <?php elseif ($image_upload_detected): ?>
        <p>Client-Side Filename: <?= $_FILES['uploaded_file']['name'] ?></p>
        <p>Apparent Mime Type:   <?= $_FILES['uploaded_file']['type'] ?></p>
        <p>Size in Bytes:        <?= $_FILES['uploaded_file']['size'] ?></p>
        <p>Temporary Path:       <?= $_FILES['uploaded_file']['tmp_name'] ?></p>
        <p>New path:              <?=$new_image_path?></p>
    <?php endif ?>

    <form method="post"  enctype="multipart/form-data">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity"><br>

        <label for="image">Image:</label>
        <input type="file" name="uploaded_file" id="uploaded_file"><br> 

        <input type="submit" name="submit" value="Add Equipment">

        
    </form>
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
                    <td><img src="uploads/<?= $row['name'] ?>.jpg" alt="<?= $row['name'] ?>"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

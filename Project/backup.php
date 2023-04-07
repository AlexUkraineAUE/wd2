<?php

require '/Applications/XAMPP/htdocs/php-image-resize-master/lib/ImageResize.php';
require '/Applications/XAMPP/htdocs/php-image-resize-master/lib/ImageResizeException.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('connect.php');

$query = "SELECT * FROM content ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();
$menuItems = $statement->fetchAll();

$query = "SELECT * FROM equipment ORDER BY id ASC";
$statement = $db->prepare($query);
$statement->execute();




$rows = $statement->fetchAll();

// file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
// Default upload path is an 'uploads' sub-folder in the current folder.
function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    
    // Get the current directory
    $current_folder = getcwd(); 
    
    // Build an array of paths segment names to be joins using OS specific slashes.
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    
    // The DIRECTORY_SEPARATOR constant is OS specific.
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

 $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0) && !empty($_FILES['image']['name']);
 $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

$errors = [];
if ($_POST) {
    
    $quantity = $_POST['quantity'];
    $name = $_POST['name'];

    if (empty($quantity)) {
        $errors[] = "Quantity is required";
    } 

    if (empty($name)) {
        $errors[] = "Name is required";
    }
    $img_name = 'No image Available';
    if (empty($errors)) {
        $query = "INSERT INTO equipment (quantity, name, img_name) VALUES (:quantity, :name, :img_name)";
        $statement = $db->prepare($query);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":quantity", $quantity);
        $errors = [];
        if ($_POST) {
            
            $quantity = $_POST['quantity'];
            $name = $_POST['name'];
        
            if (empty($quantity)) {
                $errors[] = "Quantity is required";
            } 
        
            if (empty($name)) {
                $errors[] = "Name is required";
            }
        
            $img_name = '';
            if ($image_upload_detected) { 
                $filename = str_replace(' ', '', $_FILES['image']['name']);
                $temporary_image_path  = $_FILES['image']['tmp_name'];
                $new_image_path    = file_upload_path($filename);
                $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
            
                if (file_is_an_image($temporary_image_path, $new_image_path)) {
                    $image = new \Gumlet\ImageResize($temporary_image_path);
            
                    $medium_image_path = file_upload_path("{$filename}");
                    $medium_image = $image->resizeToWidth(400);
                    $medium_image->save($medium_image_path);
                    
                    $img_name = $filename;
                }
            }
        
            if (empty($errors)) {
                $query = "INSERT INTO equipment (quantity, name, img_name) VALUES (:quantity, :name, :img_name)";
                $statement = $db->prepare($query);
                $statement->bindValue(":name", $name);
                $statement->bindValue(":quantity", $quantity);
                $statement->bindValue(':img_name', $img_name);
        
                $statement->execute();
                header("Location: equipment.php");
                exit;   
            }
        }
        
        if ($image_upload_detected) { 
            $filename = str_replace(' ', '', $_FILES['image']['name']);
            $temporary_image_path  = $_FILES['image']['tmp_name'];
            $new_image_path    = file_upload_path($filename);
            $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);
        
            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                $image = new \Gumlet\ImageResize($temporary_image_path);
        
                $medium_image_path = file_upload_path("{$filename}");
                $medium_image = $image->resizeToWidth(400);
                $medium_image->save($medium_image_path);
                
                $img_name = $filename;
                $statement->bindValue(':img_name', $img_name);
            }
        }

        $statement->execute();
        header("Location: equipment.php");
        exit;   
    }
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

</nav>


    <h2>Add Equipment</h2>



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

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

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
                <td><?= $row['id'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['name'] ?></td>
                <?php if ($row['img_name']): ?>
                <td><img src="<?= 'uploads/' . $row['img_name'] ?>" alt="Equipment Image"></td>
            <?php else: ?>
               <td> No Image Available</td>
            <?php endif; ?>
        </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
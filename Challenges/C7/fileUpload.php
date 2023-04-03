<?php

require '/Applications/XAMPP/htdocs/php-image-resize-master/lib/ImageResize.php';
require '/Applications/XAMPP/htdocs/php-image-resize-master/lib/ImageResizeException.php';

/*******w******** 
    
    Name: Alex Bondarenko
    Date: March 14, 2023
    Description: Challenge 7

****************/



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$image_upload_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] === 0);
$upload_error_detected = isset($_FILES['uploaded_file']) && ($_FILES['uploaded_file']['error'] > 0);

if ($image_upload_detected) { 
    $filename  = $_FILES['uploaded_file']['name'];
    $temporary_image_path  = $_FILES['uploaded_file']['tmp_name'];
    $new_image_path    = file_upload_path($filename);
    $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);

    if (file_is_an_image($temporary_image_path, $new_image_path)) {
        $image = new \Gumlet\ImageResize($temporary_image_path);
        $image->save($new_image_path);


        $medium_image_path = file_upload_path("{$filename}_medium.{$actual_file_extension}");
        $medium_image = $image->resizeToWidth(400);
        $medium_image->save($medium_image_path);


        $thumbnail_image_path = file_upload_path("{$filename}_thumbnail.{$actual_file_extension}");
        $thumbnail_image = $image->resizeToWidth(50);
        $thumbnail_image->save($thumbnail_image_path);

        echo "<p>File uploaded successfully at: $new_image_path</p>";
    }      
}     
    ?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My File Upload Challenge</title>
</head>
<body>

    <h1>Challenge 7</h1>
 
    <form method="post" enctype="multipart/form-data">
        <label for="uploaded_file">Filename:</label>
        <input type="file" name="uploaded_file" id="uploaded_file" />
        <input type="submit" name="submit" value='Upload Image' />
    </form>


 <?php if ($upload_error_detected): ?>

    <p>Error Number: <?= $_FILES['uploaded_file']['error'] ?></p>

<?php elseif ($image_upload_detected): ?>

    <p>Client-Side Filename: <?= $_FILES['uploaded_file']['name'] ?></p>
    <p>Apparent Mime Type:   <?= $_FILES['uploaded_file']['type'] ?></p>
    <p>Size in Bytes:        <?= $_FILES['uploaded_file']['size'] ?></p>
    <p>Temporary Path:       <?= $_FILES['uploaded_file']['tmp_name'] ?></p>
    <p>New path:              <?=$new_image_path?></p>
 <?php endif ?>
</body>
</html>
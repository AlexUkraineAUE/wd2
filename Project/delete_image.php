<?php

require('connect.php');

$id = $_POST['id'];

$query = "SELECT img_name FROM equipment WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(":id", $id);
$statement->execute();
$row = $statement->fetch();

$img_name = $row['img_name'];
$image_path = 'uploads/' . $img_name;

if (file_exists($image_path)) {
    unlink($image_path);
}

$query = "UPDATE equipment SET img_name = NULL WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(":id", $id);
$statement->execute();

header("Location: equipment.php");
exit;

<?php
    $animals = ["cat", "dog", "human","gorilla", "ocelot"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embed PHP in HTML</title>
</head>
<body>
    <h1>Animals in a Zone of Danger</h1>
    <ol>
        <!-- Alternative Syntax in HTML -->
        <?php foreach($animals as $animal): ?>
        <!-- Short Echos -->
        <li><?= $animal ?></li> 
        <?php endforeach ?>
    </ol>
</body>
</html>
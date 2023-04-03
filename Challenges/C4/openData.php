<?php

/*******w******** 
    
    Name: Alex Bondarenko
    Date: Feb 10,2023
    Description: Challenge 4

****************/

ini_set("allow_url_fopen", 1);
$parks_json = file_get_contents("https://data.winnipeg.ca/resource/hfwk-jp4h.json");
$parks =  json_decode($parks_json, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>My Open Data Challenge</title>
</head>
<body>
    <div class="container">
    <h1>Winnipeg Tree Inventory</h1>
    </div>
    
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                 <th scope="col">Common name</th>
                <th scope="col">Botanical name</th>
                <th scope="col">Neighbourhood</th>
                <th scope="col">Breast diameter (inches)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($parks as $park): ?>
                <tr>                 
                    <td><?=$park['common_name']?></td>
                    <td><?=$park['botanical_name']?></td>
                    <td><?=$park['neighbourhood']?></td>
                    <td><?=$park['diameter_at_breast_height']?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>
</html>

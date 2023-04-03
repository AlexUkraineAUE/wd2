<?php

/*******w******** 
    
    Name: Alex Bondarenko
    Date: January 7, 2022
    Description: Assignment 1

****************/

$config = [

    'gallery_name' => 'Mental Relief Gallery',
 
    'unsplash_categories' => ['Sports','Trees','Dogs','Fashion'],
 
    'local_images' => ['images/Sports.jpg','images/Trees.jpg','images/Mountains.jpg','images/Lakes.jpg'],

    'photographers' => [
        [
        'name'=> 'Mwangi Gatheca', 
        'home page' => 'https://unsplash.com/@thirdworldhippy'
        ],
        [
        'name' =>'Guillaume Jaillet', 
        'home page' => 'https://unsplash.com/@i_am_g'
        ],
        [
        'name' =>'Redd F', 
        'home page' => 'https://unsplash.com/@raddfilms'
        ],
        [
        'name' =>'Johann Walter Bantz', 
        'home page' => 'https://unsplash.com/@1walter2'
        ]
    ]         
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Assignment 1</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <h1><?= $config['gallery_name'] ?></h1> 
    
<div class="category-container">
    <?php foreach ($config['unsplash_categories'] as $category): ?>
      <div class="category">
        <h2><?= $category ?></h2>
        <img src="https://source.unsplash.com/300x200/?<?= $category ?>" alt="<?= $category ?> image">
      </div>
    <?php endforeach; ?>
</div>

<h1>
  <?php
  $image_number = count($config['local_images']);
  ?>
  <?= "$image_number Large Images" ?>
</h1>

<?php foreach ($config['local_images'] as $key => $local_image): ?>
    <img src="<?= $local_image ?>" alt="Local image">
    <p>
        <a href="<?= $config['photographers'][$key]['home page'] ?>" target="_blank"><?= $config['photographers'][$key]['name'] ?></a>
    </p>
<?php endforeach; ?>
   
</body>
</html>
<?php

/*******w******** 
    
    Name: Alex Bondarenko
    Date: January 6, 2023
    Description: HTML and php challenge.

****************/

// Task #1 Generate the date using php.
// Save it to a variable.
// Output it within a p tag in your body.
$currentDate = date("Y, m, d");

// Task #2 Hard-code an array of strings.

// Each string is a quote.

// Within the body of your html, loop through this array.

// Output each quote within a <p> tag

$quotes = ["Don’t quit. Suffer now and live the rest of your life as a champion.", 
"Don’t miss out on something that could be great just because it could also be difficult.",
"Though nobody can go back and make a new beginning… Anyone can start over and make a new ending.",
"Don’t grieve. Anything you lose comes around in another form."];

// Task #3 The following array of hashes

// contains title and URLs for websites.

$links = [

    ['title' => 'Stung Eye', 'href' => 'http://stungeye.com'],

    ['title' => 'ODM',       'href' => 'http://goo.gl/cfHwe7'],

    ['title' => 'Reddit',    'href' => 'http://reddit.com']

];

// Within the body of your html, loop through this array.

// Generate a <ul> unordered list of <a> tags using the data from each of the hashes.


// Task #4 The following hash of hashes contains information about 
// the ghosts from Pacman. The keys for the outer hash are the ghost names.

$ghosts = [

          'Shadow'  => ['nickname' => 'blinky', 'color' => 'red'],

          'Speedy'  => ['nickname' => 'pinky',  'color' => 'pink'],

          'Bashful' => ['nickname' => 'inky',   'color' => 'cyan'],

          'Pokey'   => ['nickname' => 'clyde',  'color' => 'orange'],

      ];

// Within the body of your html, loop through this hash.

// Generate a paragraph tag for each ghost, formatted like this example:

// <p>My name is Shadow. My nickname is blinky. I am red.</p>

// For an extra challenge try to display the text of the nickname in the ghost's colour. 

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8" />

<title>Intro to PHP Challenge</title>

</head>

<body>

<!-- This is where you will be writing and generating your HTML. -->
<p>The current date is: <?php echo $currentDate; ?></p>

<?php foreach ($quotes as $quote): ?>
        <p><?= $quote ?></p> 
<?php endforeach ?>

<?php foreach($links as $link): ?>
    <ul><a href="<?= $link['href'] ?>"><?= $link['title'] ?></a></ul>    
<?php endforeach ?>

<?php foreach($ghosts as $name => $ghost ): ?>
     <p><?= "My name is $name. My nickname is {$ghost['nickname']}. I am {$ghost['color']}." ?></p>
<?php endforeach ?>


<?php
  foreach ($ghosts as $name => $ghost) {
    $color = $ghost['color'];
    $nickname = $ghost['nickname'];
    echo "<p>My name is $name. My nickname is <span style='color: $color'>$nickname</span>. I am $color.</p>";
}
?>

</body>

</html>
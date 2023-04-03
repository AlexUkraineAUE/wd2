<?php 
    //  Good old Hello World
    echo "Hello World";

    //  Variables
    $cats = 13; 
    $cat_feet = $cats * 4;
    $feet_story = "<p>Once there were " . $cat_feet . " cat feet in our kitchen.</p>";
    echo $feet_story;

    //  Variable types
    $my_int = 12;
    $my_float = (float)$my_int; // Casting to a float
    unset($my_int); // Setting my_int to null
    if(!isset($my_int) && is_float($my_float)){
        echo "<p>All is well</p>";
    }

    //  Constants
    define("THE_ANSWER", 42);
    define("FULL_NAME", "Alan Simpson");

    echo "<p>" . FULL_NAME . " knows the answer: " . THE_ANSWER . "</p>";

    //  Strings (good test question)
    $name = "Bobby McGhee";
    $fancy_string = "<p>My name is $name</p>";
    $plain_string = '<p>My name is $name</p>';
    echo $fancy_string;
    echo $plain_string;

    //  Concatenating strings
    $fancy_string .= "<p>Our name is " . strlen($name) . " characters long.</p>";
    echo $fancy_string;

    //  Arrays
    $numbers = [1,2,3];
    $to_do_list = ["finish marking", "play pool", "cook dinner"];
    $to_do_list[] = "practice taxidermy";
    echo "<p>Alan {$to_do_list[0]} now!</p>";
    echo "<p>There are " . count($to_do_list) . " items in our array</p>";

    $numbers = "4,8,15,16,23,42";
    $dharma_hatch = explode(",", $numbers);
    print_r($dharma_hatch);
    foreach($dharma_hatch as $hatch){
        echo "<p>Now press $hatch</p>";
    }

    //  Functions
    function say_good_day($name){
        echo "<h3>A fine day indeed, $name";
    }

    say_good_day("Alan Simpson")
?>

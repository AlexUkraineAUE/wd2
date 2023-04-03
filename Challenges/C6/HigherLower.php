<?php

    /*******w******** 
        
        Name: Alex Bondarenko
        Date: March 13 2023
        Description: Challenge 6 Cookies

    ****************/
    
    session_start();
    
    if (!isset($_SESSION['number'])) {
        $number = rand(1, 100);
        $_SESSION['number'] = $number;
        $_SESSION['guess_count'] = 0;
    } else {
        $number = $_SESSION['number'];
    }
    
    $user_submitted_a_guess = isset($_POST['guess']);
    $user_requested_a_reset = isset($_POST['reset']);
    
    if ($user_submitted_a_guess) {
        $user_guess = $_POST['user_guess'];
        $_SESSION['guess_count']++;
        
        if ($user_guess < $number) {
            echo "Your guess is too low!";
        } elseif ($user_guess > $number) {
            echo "Your guess is too high!";
        } else {
            echo "Congratulations, you guessed the correct number in " . $_SESSION['guess_count'] . " guesses!";
        }
    }
    
    if ($user_requested_a_reset) {
        $_SESSION = [];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Number Guessing Game</title>
</head>
<body>
    <h1>Guessing Game</h1>
    
    <form method="post">
        <label for="user_guess">Your Guess</label>
        <input id="user_guess" name="user_guess" autofocus>
        <input type="submit" name="guess" value="Guess">
        <input type="submit" name="reset" value="Reset">
    </form>
</body>
</html>

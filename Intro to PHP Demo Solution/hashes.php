<?php
    //  Hashes Demo
    //  Hashes use keys to retrieve values, instead of zero based integers

    $actors = [
                'Patrick Stewart' => 'Jean-Luc Picard',
                'Kate Mulgrew' => 'Kathryn Janeway',
                'William Shatner' => 'James T. Kirk'
    ];

    echo "The best Star Trek captain was {$actors['Patrick Stewart']}.</p>";

    //  Traversing Hashes
    foreach($actors as $actor => $captain){
        echo "<p>$actor played the role of Captain $captain</p>";
    }

    //  An array of hashes
    $employees = [
                    ['name' => 'Jyn Erso',
                     'position' => 'Rebel scum'],
                    ['name' => 'Alan Simpson',
                     'position' => 'Instructor scum']
    ];

    echo "<p>{$employees[1]['name']} is {$employees[1]['position']}</p>";
    foreach($employees as $employee){
        echo "<p>{$employee['name']} is {$employee['position']}.</p>";
    }
?>
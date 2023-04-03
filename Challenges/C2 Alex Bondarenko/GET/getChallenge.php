<?php

/****************
    
    Name: Alex Bondarenko
    Date: January 15, 2023
    Description: Get challenge.

****************/

    // 	Check the GET and ensure it's set
	$animal_id = filter_input(INPUT_GET, 'animal_id', FILTER_VALIDATE_INT);
    if($animal_id === false){
        $animal_id = 0;
    }
    else{
        $animal_id = $_GET['animal_id'];
    }

    //	If a count has been supplied, display the selected animal count times
	if(isset($_GET['count'])){
		$count = filter_input(INPUT_GET, 'count', FILTER_VALIDATE_INT);
        if ($count > 20) {
            $count = 20;
        }
    }else{
        $count = 1;
    }
	
    //	An array of animals to be completed. 
    // 	Ensure that they match exactly the name of the image (minus the extension)
    $animals = ['images/Eagle.jpg', 'images/Panda.jpg', 'images/Wolf.jpg'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="mvp.css">
    <title>GET Animal Challenge</title>
</head>
<body>
    <main>
        <h1>Animals GET Challenge!</h1>
        <h2>Choose an animal by changing its relative id in the GET Parameter (for example: <a href="?animal_id=2">Wolf</a>)</h2>
        
        <table>
            <tr>
                <th>Animals ID</th>
                <th>Animals</th>
            </tr>
            <tr>
                <td>0</td>
                <td>Eagle</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Panda</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Wolf</td>
            </tr>
        </table>
        <aside>
            <!-- Use PHP Alternative Syntax to provide logic that will display the
                 selected animal 'count' times -->
            <?php for($i = 0; $i < $count; $i++): ?>
                <img src="<?php echo $animals[$animal_id]; ?>" alt="<?php echo $animals[$animal_id]; ?>">
            <?php endfor; ?>
        </aside>
    </main>
</body>
</html>

<?php

/****************
    
    Name: Alex Bondarenko
    Date: January 15, 2023
    Description: Get challenge.

****************/


if(isset($_POST['animal'])){
    $animal_id = filter_input(INPUT_POST, 'animal', FILTER_VALIDATE_INT);
    if($animal_id === false){
        $animal_id = 0;
    }
    else{
        $animal_id = $_POST['animal'];
    }

    if(isset($_POST['count'])){
        $count = filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT);
        if ($count > 20) {
            $count = 20;
        }
    }else{
        $count = 1;
    }
}

$animals = ['images/Eagle.jpg', 'images/Panda.jpg', 'images/Wolf.jpg'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="mvp.css">
	<title>POST Animal Challenge</title>
	<script src="postChallenge.js"></script>
</head>
<body>
	<main>
		<h1>Animal POST Challenge!</h1>
		<h2>Choose an animal from the List!</h2>
		<!-- Change the option text to your animal choices! -->
		<form method="post">
			<select name="animal">
				<option value=0>Eagle</option>
				<option value=1>Panda</option>
				<option value=2>Wolf</option>
			</select>
			<label>Count:</label>
			<input type="range" name="count" id="count" min="1" max="20" step="1" value="1" />
			<output for="count" class="count-output"></output>
			<button type="submit">Submit</button>
		</form>

		<aside>			
   		 <?php for($i = 0; $i < $count; $i++): ?>
        <img src="<?php echo $animals[$animal_id]; ?>" alt="<?php echo $animals[$animal_id]; ?>">
    	<?php endfor; ?>
		</aside>
		
	</main>
</body>
</html>
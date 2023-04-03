<?php
  $people_json = file_get_contents('people.json');
  $people = json_decode($people_json, true); 
  // Adding "true" converts the JSON from an Object to a Hash
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title>JSON People</title>
</head>
<body>
  <p>The first person's name: <?= $people[0]['name'] ?></p>
  <p>The second person's city: <?= $people[1]['address']['city'] ?></p>
  <?php foreach($people as $person): ?>
    <p><?= $person['name'] ?> lives in <?= $person['address']['postal_code'] ?>.</p>
  <?php endforeach ?>
</body>
</html>
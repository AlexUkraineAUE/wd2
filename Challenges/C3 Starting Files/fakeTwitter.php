<?php
/*******w******** 
    
    Name: Alex  Bondarenko
    Date: January 22, 2023
    Description: Twitter Challenge

****************/
require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM tweets ORDER BY id DESC";

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute();

//  Sanitize user input to escape HTML entities and filter out dangerous characters.

if ($_POST && !empty($_POST['tweet']) && strlen($_POST['tweet']) <= 140) {
    $tweet = filter_input(INPUT_POST, 'tweet', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "INSERT INTO tweets (status) VALUES (:status)";
    $statement = $db->prepare($query);
    $statement->bindValue(":status", $tweet);
    if ($statement->execute()) {
        header("Location: fakeTwitter.php");
        exit;
    } else {
        echo "Error";
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>My Fake Twitter</title>
</head>
<body>

<form action="fakeTwitter.php" method="post">
<label for="tweet">What's on your mind?</label>
    <input type="text" id="tweet" name="tweet" placeholder="Type here...">
    <input type="submit" value="Tweet!">


<?php if ($statement->rowCount() == 0) : ?>
    <h1> No tweets found </h1>
<?php else: ?>
    <ul>
        <?php while($row = $statement->fetch()): ?>
            <li><?= $row['status'] ?> </li>
        <?php endwhile ?>
    </ul>
    
<?php endif; ?>

<?php if ($_POST) : ?>
    <?php if (empty($_POST['tweet'])) : ?>
        <h2>Tweet can not be empty </h2>
    <?php elseif (strlen($_POST['tweet']) > 140) : ?>
        <h3>Tweet can not be more than 140 characters</h3>
    <?php endif; ?>
<?php endif; ?>
</form>

</body>
</html>

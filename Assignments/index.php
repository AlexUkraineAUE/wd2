<?php

/*******w******** 
    
    Name: Alex Bondarenko
    Date: January 25, 2023
    Description: Assignment 3 main page

****************/

require('connect.php');

if(isset($_GET['id'])) {

    $query = "SELECT * FROM blog WHERE id = :id LIMIT 1";

    $statement = $db->prepare($query);

    $statement->bindValue(":id", $_GET['id']);

    $statement->execute();


} else {
  
    $query = "SELECT * FROM blog ORDER BY id DESC";

    $statement = $db->prepare($query);

    $statement->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>My Blog - Home Page</title>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <h1><a href="index.php">Assignment 3 Blog</a></h1>
    </div>

<ul id="menu">
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="post.php">New Post</a></li>
</ul>

<div id="all_blogs">
<ul>
<?php for($i = 0; $i < 5; $i++): ?>
    <div class="blog_post">
        <?php if($row = $statement->fetch()): ?>
            <h2><a href="index.php?id=<?=$row['id']?>"><?= $row['title'] ?></a></h2>
            <p><small></s><?=$row['stamp'] ?> <a href="edit.php?id=<?=$row['id']?>" class="edit_btn">edit</a></small></p>
            <?php if(strlen($row['post'])>200): ?>
                <li><?= substr($row['post'], 0, 200) ?>
                <?php if(!isset($_GET['id']) && strlen($row['post'])>200): ?>
                    <a href="index.php?id=<?=$row['id']?>"> Read Full Post...</a>
                <?php endif; ?>
                </li>
            <?php else: ?>
                <li><?= $row['post'] ?></li>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
<?php endfor; ?>
</ul>
</div>
<div id="footer">
Copywrong 2023 - No Rights Reserved
</div>

</div> 
</body>
</html>
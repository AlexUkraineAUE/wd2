<?php
   /*******w******** 
       
       Name: Alex Bondarenko
       Date: January 27,2023
       Description: Script for editing or deleting the post
   
   ****************/
   
   require('connect.php');
   require('authenticate.php');
   
   if(isset($_GET['id'])) {
   
       $query = "SELECT * FROM blog WHERE id = :id LIMIT 1";
   
       $statement = $db->prepare($query);
   
       $statement->bindValue(":id", $_GET['id']);
   
       $statement->execute();
       $post = $statement->fetch();
   }
   
   if ($_POST && isset($_POST['title']) && isset($_POST['post']) && isset($_POST['submit']) ) {
       // Sanitize user input to escape HTML entities and filter out dangerous characters.
       $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $post = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
       
       // Build the parameterized SQL query and bind to the above sanitized values.
       $query     = "UPDATE blog SET title = :title, post = :post WHERE id = :id";
       $statement = $db->prepare($query);
       $statement->bindValue(':title', $title);        
       $statement->bindValue(':post', $post);
       $statement->bindValue(':id', $id, PDO::PARAM_INT);
       
       // Execute the UPDATE.
       $statement->execute();
       
       // Redirect after update.
       header("Location: index.php");
       exit;
   }
   if (isset($_POST['delete'])) { // Check if delete button is clicked
       $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
       $query = "DELETE FROM blog WHERE id = :id";
       $statement = $db->prepare($query);
       $statement->bindValue(':id', $id, PDO::PARAM_INT);
       $statement->execute();
       header("Location: index.php");
       exit;
   } else if (isset($_GET['id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
       // Sanitize the id. Like above but this time from INPUT_GET.
       $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
       
       // Build the parametrized SQL query using the filtered id.
       $query = "SELECT * FROM blog WHERE id = :id";
       $statement = $db->prepare($query);
       $statement->bindValue(':id', $id, PDO::PARAM_INT);
       
       $statement->execute();
       $quote = $statement->fetch();
   } else {
       $id = false; 
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" post="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="newstyles.css">
      <title>Edit this Post!</title>
   </head>
   <body>
      <!-- Remember that alternative syntax is good and html inside php is bad -->
      <div id="wrapper">
         <div id="header">
            <h1><a href="index.php">Assignment 3 Edit Post</a></h1>
         </div>
         <ul id="menu">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="post.php">New Post</a></li>
         </ul>
         <div id="all_blogs">
            <form method="post" action = "edit.php">
               <fieldset>
                  <legend>Edit Blog Post</legend>
                  <p>
                     <input type="hidden" name="id" value="<?= $post['id'] ?>">
                     <label for="title">Title</label>
                     <input name="title" id="title" value="<?= $post['title'] ?>">
                  </p>
                  <p>
                     <label for="content">Content</label>
                     <textarea name="post" id="post"><?= $post['post'] ?></textarea>
                  </p>
                  <p>
                     <input type="submit" name="submit" value="update">
                     <input type="submit" name="delete" value="delete">
                  </p>
               </fieldset>
            </form>
         </div>
         <div id="footer">
            Copywrong 2023 - No Rights Reserved
         </div>
      </div>
   </body>
</html>
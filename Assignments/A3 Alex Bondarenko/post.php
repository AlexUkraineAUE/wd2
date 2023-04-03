<?php
   /*******w******** 
       
       Name: Alex Bondarenko
       Date: January 27,2023
       Description: Assignment 3 new post script
   
   ****************/
   
   require('connect.php'); // add the missing connect file
   require('authenticate.php');
   
   if ($_POST) {
       $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $post = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
       
       $query = "INSERT INTO blog (title, post) VALUES (:title, :post)";
       $statement = $db->prepare($query);
       $statement->bindValue(":title", $title);
       $statement->bindValue(":post", $post);
       if ($statement->execute()) {
           header("Location: index.php");
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
      <link rel="stylesheet" href="newstyles.css">
      <title>My Blog Post!</title>
   </head>
   <body>
      <div id="wrapper">
         <div id="header">
            <h1><a href="index.php">Assignment 3 New Post</a></h1>
         </div>
         <ul id="menu">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="post.php">New Post</a></li>
         </ul>
         <div id="all_blogs">
            <form action="post.php" method="post">
               <fieldset>
                  <legend>New Blog Post</legend>
                  <p>
                     <label for="title">Title</label>
                     <input name="title" id="title">
                  </p>
                  <p>
                     <label for="content">Content</label>
                     <textarea name="content" id="content"></textarea>
                  </p>
                  <p>
                     <input type="submit" value="Create">
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
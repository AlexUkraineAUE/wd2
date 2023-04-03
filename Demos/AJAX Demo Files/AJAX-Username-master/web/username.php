<?php

  /* 

  This script pretends to check the availability of a username.

  Normally this would be done by checking the users name in the DB. 

  Returns JSON in this form: 

    { 
      'success': true/false,
      'usernameAvailable': true/false
    }

  Properties:
  - success             true unless a username is not provided in $_GET['username]
  - usernameAvailable   true if username is not present in $registered_usernames.

  */ 

  $registered_usernames = ['wallyg', 'dglutton', 'stungeye', 'mirage', 'chin', 'alan'];

  $response = [
    'success' => false,
    'usernameAvailable' => false
  ];

  if (isset($_GET['username']) && (strlen($_GET['username']) !== 0)) {
    $response['usernameAvailable'] = ! in_array(strtolower($_GET['username']), $registered_usernames);
    $response['success'] = true;
  } 

  // Set the JSON MIME content type so that it isn't sent as text/html
  header('Content-Type: application/json');

  // Encode the $response into JSON and echo.
  echo json_encode($response);
?>










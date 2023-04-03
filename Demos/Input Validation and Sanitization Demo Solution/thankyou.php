<?php
    //  Ensure the data was entered
    if(isset($_POST['fname'])){
        $content = "Thank you for your submission, {$_POST['fname']}.";
    }

    //  Validate the student number
    function filterdata(){
        return filter_input(INPUT_POST, 'studentnum', FILTER_VALIDATE_INT);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formstyle.css">
    <title>Thank You</title>
</head>
<body>
   <main id="wrapper">
     <h1><?= $content ?></h1>
     <?php if(filterdata()): ?>
     <table>
        <tr>
            <td>Name:</td>
            <td><?= $_POST['fname'] . " " . $_POST['lname'] ?></td>
        </tr>
        <tr>
            <td>Student #:</td>
            <td><?= $_POST['studentnum'] ?></td>
        </tr>
        <tr>
            <td>Program:</td>
            <td><?= $_POST['program'] ?></td>
        </tr>
        <?php if($_POST['program'] == "BIT"): ?>
            <tr>
                <td>Major:</td>
                <td><?= $_POST['bitmajor'] ?></td>
            </tr>
        <?php endif ?>
        <?php if($_POST['program'] == "BA"): ?>
            <tr>
                <td>Major:</td>
                <td><?= $_POST['bamajor'] ?></td>
            </tr>
        <?php endif ?>
     </table>
     <?php else: ?>
        <h2>You did not supply an appropriate student number.</h2>
     <?php endif?>
   </main>
    
</body>
</html>

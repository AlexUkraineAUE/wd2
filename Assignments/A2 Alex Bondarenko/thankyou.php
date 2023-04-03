<!-----------------

    Assignment 2
    Name: Alex Bondarenko
    Date: Jan 19, 2023
    Description: Form validation

------------------->
<?php

// Validate postal code
function validatePostalCode($postalCode) {
    $pattern = '/^[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ -]?\d[ABCEGHJ-NPRSTV-Z]\d$/i';
    return preg_match($pattern, $postalCode) ? true : false;
}
$postalCode = $_POST['postal'];
$validPostalCode = validatePostalCode($postalCode);


// Credit card month
function check_month($month) {
    return (1 <= $month && $month <= 12);
}

$validMonth = check_month(filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT));

//CC year
$currentYear = date('Y');
$year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
$validYear = ($currentYear <= $year && $year <= $currentYear + 5);

// CC type
$validCardTypes = array('VISA', 'Mastercard', 'AmEx');
$card_type = filter_input(INPUT_POST, 'cardtype', FILTER_SANITIZE_STRING);
$validCardType = true;

if (in_array($card_type, $validCardTypes)) {
    $validCardType = $card_type;
}

//CC number length
function check_cardnumber($cardnumber) {
    return (strlen($cardnumber) === 10);
}
$cardnumber = filter_input(INPUT_POST, 'cardnumber', FILTER_SANITIZE_NUMBER_INT);
$validCardNumber = check_cardnumber($cardnumber);

// Province
$province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
$validProvinces = array('AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'ON', 'PE', 'QC', 'SK', 'NT', 'NU', 'YT');
$province = $_POST['province'];
$validProvince = true;

if (in_array($province, $validProvinces)) {
    $validProvince = $province;
}



// Check empty fields
function checkRequiredFields() {
    $requiredFields = [
        'fullname',
        'cardname',
        'address',
        'city',
    ];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return false;
        }
    }
    return true;
}
$validRequiredFields = checkRequiredFields();

// Valid email
function filteremail(){
    return filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
}

$validEmail = filteremail();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="thankyoustyles.css">
    <title>Thanks for your order!</title>
</head>
<body>
<?php if( !$validCardType || !$validPostalCode || !$validMonth || !$validYear  || !$validRequiredFields 
        || !$validEmail || !$validProvince) : ?>
<div class="error-message">
    <h1>Error!</h1>
    <p>The form can not be processed!</p>
</div>
<?php else: ?>
    <div class = invoice>
        <h1>Thanks for your order, <?= $_POST['fullname'] ?> </h1>
        <h2>Here is the summary of your order:</h2>
        <table>
            
            <tr>
                <th class = alignleft> Address information</th>           
            </tr>
            <tr>
                <td class = alignright>Address:</td>
                <td><?= $_POST['address'] ?></td>
                <td class = alignright>City:</td>
                <td><?= $_POST['city'] ?></td>
            </tr>
            <tr>
                <td class = alignright>Province:</td>
                <td><?= $_POST['province'] ?> </td>
                <td class = alignright>Postal Code:</td>
                <td><?= $_POST['postal'] ?> </td>
            </tr>
            <tr>
                <td class = alignright>Email:</td>
                <td><?= $_POST['email'] ?> </td>
            </tr>
        </table>
        <table>
            <tr>
                <th class = alignleft> Order Information</th>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>Description</td>
                <td>Cost</td>
            </tr>
        </table>
    </div> 
<?php endif; ?>
</body>
</html>

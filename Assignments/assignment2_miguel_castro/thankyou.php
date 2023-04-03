<?php

/*******w******** 
    
    Name: Miguel Castro
    Date: 2023-01-18
    Description:  Page that receives the order data and shows an invoice.

 ****************/

// Initialize variables for storing form data and error messages
$email = "";
$postal = "";
$cardnumber = "";
$month = "";
$year = "";
$cardtype = "";
$fullname = "";
$cardname = "";
$address = "";
$city = "";
$province = "";
$errors = array();

function createItem($description, $cost, $name)
{
    return [
        'Description' => $description,
        'Cost' => $cost,
        'Quantity' => !!filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT)
            ? filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_INT) : 0,
    ];
}

$items = [
    createItem('iMac', 1899.99, 'qty1'),
    createItem('Razer Mouse', 79.99, 'qty2'),
    createItem('WD HDD', 179.99, 'qty3'),
    createItem('Nexus', 249.99, 'qty4'),
    createItem('Drums', 119.99, 'qty5')
];

$totalCost = 0;
foreach ($items as $item) {
    $totalCost += $item['Cost'] * $item['Quantity'];
}

// Validate form data using filter_input function
!!filter_input(
    INPUT_POST,
    'email',
    FILTER_VALIDATE_EMAIL
) ? $email =  filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : $errors[] = "Invalid email address";

!!filter_input(
    INPUT_POST,
    'postal',
    FILTER_VALIDATE_REGEXP,
    array("options" => array("regexp" => "/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/"))
) ? $postal = filter_input(INPUT_POST, 'postal', FILTER_SANITIZE_SPECIAL_CHARS) : $errors[] = "Invalid Canadian postal code";


if (!!filter_input(INPUT_POST, 'cardnumber', FILTER_VALIDATE_INT)) {
    $cardnumber = filter_input(INPUT_POST, 'cardnumber', FILTER_SANITIZE_NUMBER_INT);
    if (strlen($cardnumber) != 10) {
        $errors[] = "Credit card number must be exactly 10 digits";
        $cardnumber = "";
    }
} else {
    $errors[] = "Invalid credit card number";
}

!!filter_input(
    INPUT_POST,
    'month',
    FILTER_VALIDATE_INT,
    array("options" => array("min_range" => 1, "max_range" => 12))
) ? $month =  filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT) : $errors[] = "Invalid credit card month";

!!filter_input(
    INPUT_POST,
    'year',
    FILTER_VALIDATE_INT,
    array("options" => array("min_range" => date("Y"), "max_range" => date("Y") + 5))
) ? $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT) : $errors[] = "Invalid credit card year";

filter_input(INPUT_POST, 'cardtype', FILTER_SANITIZE_SPECIAL_CHARS) === "" || empty($_POST['cardtype'])
    ?  $errors[] = "Credit card type must be selected"
    : $cardtype = filter_input(INPUT_POST, 'cardtype', FILTER_SANITIZE_SPECIAL_CHARS);


filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS) === ""
    ? $errors[] = "Full name must not be blank"
    : $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);


filter_input(INPUT_POST, 'cardname', FILTER_SANITIZE_SPECIAL_CHARS) === ""
    ? $errors[] = "Card name must not be blank"
    : $cardname = filter_input(INPUT_POST, 'cardname', FILTER_SANITIZE_SPECIAL_CHARS);

filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS) === ""
    ? $errors[] = "Address must not be blank"
    : $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS) === ""
    ? $errors[] = "City must not be blank"
    : $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);

$validProvinces = array("AB", "BC", "MB", "NB", "NL", "NS", "NT", "NU", "ON", "PE", "QC", "SK", "YT");
if (!in_array($_POST['province'], $validProvinces)) {
    $errors[] = "Invalid province selection";
} else {
    filter_input(INPUT_POST, 'province', FILTER_SANITIZE_SPECIAL_CHARS) === ""
        ? $errors[] = "Province must be selected"
        : $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_SPECIAL_CHARS);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="thankyou.css">
    <title>Thanks for your order!</title>
</head>

<body>
    <div class="invoice">
        <?php if (count($errors) > 0) : ?>
            <h1>The form could not be processed due to the following errors:</h1>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        <?php else : ?>
            <h2>Thanks for your order <?= $fullname ?>.</h2>
            <h3>Here's a summary of your order:</h3>
            <table>
                <tbody>
                    <tr>
                        <td colspan="4">
                            <h3>Address Information</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="alignright"><span class="bold">Address:</span>
                        </td>
                        <td><?= $address ?></td>
                        <td class="alignright"><span class="bold">City:</span>
                        </td>
                        <td><?= $city ?></td>
                    </tr>
                    <tr>
                        <td class="alignright"><span class="bold">Province:</span>
                        </td>
                        <td><?= $province ?></td>
                        <td class="alignright"><span class="bold">Postal Code:</span>
                        </td>
                        <td><?= $postal ?> </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="alignright"><span class="bold">Email:</span>
                        </td>
                        <td colspan="2"><?= $email ?></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h3>Order Information</h3>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="bold">Quantity</span>
                        </td>
                        <td><span class="bold">Description</span>
                        </td>
                        <td><span class="bold">Cost</span>
                        </td>
                    </tr>
                    <?php foreach ($items as $item) : ?>
                        <?php if ($item['Quantity'] > 0) : ?>
                            <tr>
                                <td><?= $item['Quantity'] ?></td>
                                <td><?= $item['Description'] ?></td>
                                <td class="alignright"><?= $item['Cost'] ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="2" class="alignright"><span class="bold">Totals</span></td>
                        <td class="alignright">
                            <span class="bold">$<?= number_format($totalCost, 2, '.', ',') ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</body>

</html>
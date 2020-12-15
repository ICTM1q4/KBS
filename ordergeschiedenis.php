<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    <link rel='stylesheet' href='CSS/contact.css'>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<?php
include "connect.php";

$CustomerID = $_SESSION['Customer'];

$Query = "
SELECT OrderID, TotalPrice, OrderDate
FROM weborder
WHERE Payment = 1
AND CustomerID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $CustomerID);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);


?>

<body style="background-attachment: fixed;">
     <div style="min-height: 430px; width: 80%; margin-left: auto; margin-right: auto; margin-top: 50px;">
        <?php foreach ($ReturnableResult as $row){ ?>
        <div style=' margin-bottom: 50px;'>
            <a href="">
                <div style="height: 200px; width: 100%; background-color: rgba(255,255,255,0.3); color: white;">
                    <h1><?php print("Bestelling nr. " . $row['OrderID']); ?></h1>
                    <h1><?php print("Totaalprijs is: €" . $row['TotalPrice']); ?></h1>
                    <h1><?php print("Bestelt op: " . $row['OrderDate']); ?></h1>
                </div>
            </a>
            </div>
        <?php } ?>
     </div>
</body>

<footer style="margin-top: 240px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>




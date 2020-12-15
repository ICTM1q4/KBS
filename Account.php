<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>
        Login
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<?php

include "connect.php";

$CustomerID = $_SESSION['Customer'];
$switch = 0;

$Query = "
        SELECT Payment
        FROM weborder
        WHERE CustomerID = ?
        AND Payment = 1;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $CustomerID);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach ($ReturnableResult as $row){
    if ($row['Payment'] == 1){
        $switch = 1;
    }
}
?>

<body style="height: 100%; background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
    <div style="color: white; margin-left: auto; margin-right: auto; width: 40%; margin-top: 40px; background-color: rgba(0,0,0,0.3); padding-top: 10%; padding-bottom: 10%;"> 
        <p style="text-align: center;">Je bent ingelogd als: <?php print($_SESSION["Naam"]);?></p>
        <p style="text-align: center;">Je orderid is: <?php print($_SESSION["OrderID"]);?></p>
        <div style="width: 50%; margin: auto;">
        <a href="bewerken.php" >
            <h1 style="color: white; text-align: center; font-size: 150%;">gegevens bewerken</h1>
        </a>
        <?php if ($switch = 0){ ?>
        <a href="ordergeschiedenis.php" >
            <h1 style="color: white; text-align: center; font-size: 150%;">Ordergeschiedenis</h1>
        </a>
        <?php } ?>
        <a href="logout.php" >
            <h1 style="color: white; text-align: center;">logout</h1>
        </a>
        </div>
        
    </div>
</body>
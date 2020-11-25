<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel='stylesheet' href='CSS/style.css'>
</head>
<header>
<?php
include __DIR__ . "/Header.php";
include __DIR__ . "/winkelmandConnect.php";
?>
</header>
<body >
<div id="winkelmandje" style="margin-top: 20px; margin-left: 30px;">
<h1>Uw winkelmand </h1>
<table> <!--De inhoud van de winkelman moet met SQL werken! Dit is slechts een voorbeeld!-->
    <tr>
        <th>Productnaam</th>
        <th>Aantal</th>
        <th>Prijs</th>
    </tr>
    <tr>
        <td>Voorbeeldproduct 1</td>
        <td>1</td>
        <td>5,99</td>
        <td><button>Verwijderen</button></td>
    </tr>
    <tr>
        <td>Voorbeeldproduct 2</td>
        <td>2</td>
        <td>18,99</td>
        <td><button>Verwijderen</button></td>
    </tr>
</table>
<?php

$Statement = "";

$Query = "
                SELECT WebOrderLine.StockItemID as Product, WebOrderLine.OrderAmount as Amount 
                FROM WebOrder
                RIGHT JOIN WebCustomer ON WebOrder.CustomerID = WebCustomer.CustomerID
                JOIN WebOrderLine ON WebOrder.OrderID = WebOrderLine.OrderID
                WHERE WebCustomer.Username = ?
                AND WebCustomer.Password = ?;";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach ($ReturnableResult as $value){

    
    print "<h1> $value </h1> <br>" ;
    print("<p style='color: white;'>hoi</p>");
}
?>
Totaalprijs:    25,98 Euro<br>
<button>Kopen die handel!</button>
</div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
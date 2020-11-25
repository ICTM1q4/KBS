<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NerdyGadgets</title>
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
                SELECT SI.StockItemName as Product, WebOrderLine.StockItemID as ProductID, WebOrderLine.OrderAmount as Amount, ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice
                FROM WebOrder
                RIGHT JOIN WebCustomer ON WebOrder.CustomerID = WebCustomer.CustomerID
                JOIN WebOrderLine ON WebOrder.OrderID = WebOrderLine.OrderID
                JOIN stockitems SI ON SI.StockItemID = WebOrderLine.StockItemID
                WHERE WebCustomer.Username = ?
                AND WebCustomer.Password = ?;";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    print("<table>");

foreach ($ReturnableResult as $row){

    print("<tr>");
    print(""); //image
    print("<td><h1>". $row['Product'] ."</h1> </td>") ; //artikelnaam
    print("<td><p style='color: white;'>".$row['ProductID']."</p> </td>"); //artikelcode
    print("<td><p style='color: white;'></p>".$row['Amount']." </td>"); //artikelamount
    print("<td><p style='color: white;'></p>".$row['SellPrice']. "</td>"); //artikelprijs
    print("</tr>");
}
print("</table>");
?>
Totaalprijs:    25,98 Euro<br>
<button>Kopen die handel!</button>
</div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel='stylesheet' href='style.css'>
</head>
<header>
<?php
include __DIR__ . "/Header.php";
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
Totaalprijs:    25,98 Euro<br>
<button>Kopen die handel!</button>
</div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
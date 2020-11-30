<?php 
include "connect.php";
session_start();
if(isset($_GET['product_id'])){ $ProductID = $_GET['product_id'];};
$OrderID = "";
$Statement = "";

$Query = "
                SELECT weborder.OrderID
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

    $OrderID = $_SESSION['OrderID'];

    $Query = "
    SELECT ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice,
    FROM stockitems
    WHERE stockitems.StockItemID = i;";


$Statement = mysqli_prepare($Connection, $Query);

mysqli_stmt_execute($Statement);
mysqli_stmt_bind_param($Statement, "i", $ProductID);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
$Price = $ReturnableResult['SellPrice'];



$Query = "
                INSERT INTO weborderline (StockItemID, OrderAmount, Price, OrderID)
                VALUES (?, 1, ?, ?);";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "iii", $ProductID, $Price, $OrderID);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    print_r($ReturnableResult);
    //header('Location: http://localhost:83/Github/KBS-1/winkelmand.php');
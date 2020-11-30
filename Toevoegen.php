<?php 
include "connect.php";
session_start();

//PREPARE ALL VARIABLES
$ProductID = $_SESSION['product'];
if(isset($_GET['product'])){
    $ProductID = $_GET['product'];
    }
$OrderID = "";
$Statement = "";

//GET ORDER ID FROM DATABASE THAT CORRESPONDS TO CUSTOMER ID AND SET IN SESSION
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

//GET SELL PRICE FROM PRODUCT AND SET VARIABLE
    $Query = "
    SELECT ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice
    FROM stockitems SI
    WHERE SI.StockItemID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $ProductID);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
foreach($ReturnableResult as $ReturnableResult){
    $Price = $ReturnableResult['SellPrice'];
}

//MAKE A NEW ORDERLINE AND ADD THE PREPARED DATA
$Query = "
                INSERT INTO weborderline (StockItemID, OrderAmount, Price, OrderID)
                VALUES (?, 1, ?, ?);";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "sss", $ProductID, $Price, $OrderID);
    mysqli_stmt_execute($Statement);
    
//GET URL AND GO TO winkelmand.php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$position = strrpos($actual_link, "/");
$count = strlen($actual_link);
$positionChar = substr($actual_link, $position);
while ($positionChar != ""){
    $actual_link = substr_replace($actual_link, "", $position);
    $positionChar = substr($actual_link, $position);
}

header('Location: ' . $actual_link . '/winkelmand.php');
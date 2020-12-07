<?php

include "connect.php";
session_start();
$rating = "";
$Beschrijving = "";
$Product = "";
$Customer = 0;
if (isset($_GET['ratings'])){
    $rating = $_GET['ratings'];
}

if (isset($_GET['beschrijving']) && $_GET['beschrijving'] != ""){
    $Beschrijving = $_GET['beschrijving'];
}
if (isset($_GET['Product'])){
    $Product = $_GET['Product'];
}

$Query = "
        SELECT CustomerID
        FROM weborder
        WHERE OrderID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $_SESSION['OrderID']);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach($ReturnableResult as $row){
    $Customer = $row['CustomerID'];
    print($Customer);
}


$Query = "
        SELECT CustomerID, StockItemID
        FROM webreview
        WHERE CustomerID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $Customer);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach ($ReturnableResult as $row){
    print("hoi");
    if ($Customer == $row['CustomerID'] && $Product == $row["StockItemID"]){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $position = strrpos($actual_link, "/");
        $count = strlen($actual_link);
        $positionChar = substr($actual_link, $position);
        while ($positionChar != ""){
            $actual_link = substr_replace($actual_link, "", $position);
            $positionChar = substr($actual_link, $position);
        }
        $switch = 1;
        header('Location: ' . $actual_link . '/view.php?id=' . $_GET['Product'] . '&review=fout');
    }
}

if ($switch != 1){
    $Query = "
    INSERT INTO webreview (StockItemID, CustomerID, Rating, Beschrijving)
    VALUES(?,?,?,?);";
    
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "siss", $Product, $Customer, $rating, $Beschrijving);
    mysqli_stmt_execute($Statement);
    
    
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $position = strrpos($actual_link, "/");
            $count = strlen($actual_link);
            $positionChar = substr($actual_link, $position);
            while ($positionChar != ""){
                $actual_link = substr_replace($actual_link, "", $position);
                $positionChar = substr($actual_link, $position);
            }
            header('Location: ' . $actual_link . '/view.php?id=' . $_GET['Product']);
}

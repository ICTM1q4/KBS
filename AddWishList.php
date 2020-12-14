<?php

include "connect.php";
session_start();

if(isset($_SESSION['loggedin']) == false){
        
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $position = strrpos($actual_link, "/");
    $count = strlen($actual_link);
    $positionChar = substr($actual_link, $position);
    while ($positionChar != ""){
        $actual_link = substr_replace($actual_link, "", $position);
        $positionChar = substr($actual_link, $position);
    }
    header('Location: ' . $actual_link . '/login.php');
}

$ListID = "";
$Product = "";
$Customer = $_SESSION['Customer'];
$Price = "";
$Description = "";
$dupe = 0;

if (isset($_GET['product'])){
    $Product = $_GET['product'];
}

$Query = "
        SELECT ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice, StockItemName as Name
        FROM stockitems SI
        WHERE SI.StockItemID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $Product);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    foreach($ReturnableResult as $ReturnableResult){
        $Price = $ReturnableResult['SellPrice'];
        $Description = $ReturnableResult['Name'];
    }


    $Query = "
    SELECT WishListID as ID
    FROM webwishlist
    WHERE CustomerID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $Customer);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach($ReturnableResult as $row){
    $ListID = $row['ID'];
}



$Query = "
        SELECT *
        FROM webwishlistline
        WHERE WishListID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $ListID);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    foreach($ReturnableResult as $row){
        if ($row['StockItemID'] == $Product){
            $dupe = 1;
            print('jaja');
        }

    }

    if ($dupe == 1){
        $Query = "
        DELETE FROM webwishlistline 
        WHERE StockItemID = ?
        AND WishListID = ?;";
    
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ss", $Product, $ListID);
    mysqli_stmt_execute($Statement);
    print('jaja');




    }
    else {
        $Query = "
        INSERT INTO webwishlistline (WishListID, Price, Description, StockItemID)
        VALUES (?,?,?,?)
        ";
    
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ssss", $ListID, $Price, $Description, $Product);
    mysqli_stmt_execute($Statement);
print('jaja');


    }
    $actual_link = $_GET['url'];
            $position = strrpos($actual_link, "/");
            $count = strlen($actual_link);
            $positionChar = substr($actual_link, $position);
            while ($positionChar != ""){
                $actual_link = substr_replace($actual_link, "", $position);
                $positionChar = substr($actual_link, $position);
            }
            if(isset($_GET['url'])){
                if ($_GET['url']){
                    print($_GET['url']);
                }
            } else {
                print('index.php');
            }
            header('Location: ' . $_GET['url']);
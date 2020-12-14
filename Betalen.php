<?php 
include "connect.php";
session_start();

$OrderID = $_SESSION['OrderID'];
$CustomerID = $_SESSION['Customer'];
$date = date('Y-m-d H:i:s');
$Price = $_POST['price'];
print($_POST['price']);
$Query = "
        UPDATE weborder
        SET Payment = 1, TotalPrice = ?, OrderDate = ?
        WHERE CustomerID = ?
        AND OrderID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ssss", $Price, $date, $CustomerID, $OrderID);
    mysqli_stmt_execute($Statement);

    $Query = "
    INSERT INTO weborder (CustomerID)
    VALUES (?);";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $CustomerID);
mysqli_stmt_execute($Statement);


$Query = "
    SELECT OrderID FROM weborder
    WHERE Payment = 0
    AND CustomerID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $CustomerID);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach ($ReturnableResult as $row){
    $_SESSION['OrderID'] = $row['OrderID'];
    break;
}





    
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $position = strrpos($actual_link, "/");
    $count = strlen($actual_link);
    $positionChar = substr($actual_link, $position);
    while ($positionChar != ""){
        $actual_link = substr_replace($actual_link, "", $position);
        $positionChar = substr($actual_link, $position);
    }
    header('Location: ' . $actual_link . '/index.php');
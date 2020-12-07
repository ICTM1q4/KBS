<?php 
include "connect.php";
session_start();

$CustomerID = $_SESSION['Customer'];
$Product = $_GET['product'];

$Query = "
        DELETE FROM webreview
        WHERE CustomerID = ?
        AND StockItemID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $CustomerID, $Product);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $position = strrpos($actual_link, "/");
            $count = strlen($actual_link);
            $positionChar = substr($actual_link, $position);
            while ($positionChar != ""){
                $actual_link = substr_replace($actual_link, "", $position);
                $positionChar = substr($actual_link, $position);
            }
            header('Location: ' . $actual_link . '/view.php?id=' . $Product);
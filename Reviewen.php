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

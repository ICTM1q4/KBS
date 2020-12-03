<?php
include "connect.php";

//PREPARE ALL VARIABLES
    $ID = $_POST["ID"];

//DELETE ORDERLINE WHAT CORRESPONDS TO THE ORDERLINEID OF THE BUTTON
    $Query = '
        DELETE FROM weborderline
        WHERE OrderLineID = ?';

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, 's', $ID);
    if ($ID != ""){
        mysqli_stmt_execute($Statement);
    }

//GET URL AND GO TO winkelmand.php
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $position = strrpos($actual_link, "/");
    $count = strlen($actual_link);
    $positionChar = substr($actual_link, $position);
    while ($positionChar != ""){
        $actual_link = substr_replace($actual_link, "", $position);
        $positionChar = substr($actual_link, $position);
    }
    $_POST['url'] = preg_replace("/\r|\n/", "", $_POST['url']);
    header('Location: ' . $actual_link . '/winkelmand.php?url=' . $_POST['url']);

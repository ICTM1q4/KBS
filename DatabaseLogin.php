<?php

include "connect.php";

$gebruikersNaam = "";
$gebruikersWachtwoord = "";



if (isset($_POST["Username"]) && isset($_POST["Password"])){
    $gebruikersNaam = $_POST["Username"];
    $gebruikersWachtwoord = $_POST["Password"];
}
print($gebruikersWachtwoord);
$gebruikersNaam = password_hash($gebruikersNaam, PASSWORD_BCRYPT);

$Query = "
                SELECT username, password, firstname, lastname
                FROM webcustomer
                WHERE username = ?
                AND password = ?;";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach ($ReturnableResult as $ReturnableResult){
    if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
        print("Welkom ".$ReturnableResult['firstname']. $ReturnableResult['lastname'].", je bent zojuist ingelogd!");
        session_start();
        $_SESSION["Naam"] = $gebruikersNaam;
        
        $Query = "
                SELECT OrderID
                FROM weborder
                WHERE CustomerID IN ( SELECT CustomerID FROM webcustomer 
                WHERE username = ?
                AND password = ?);";


        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
        mysqli_stmt_execute($Statement);
        $ReturnableResult = mysqli_stmt_get_result($Statement);
        $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
        foreach ($ReturnableResult as $ReturnableResult){
        $_SESSION["OrderID"] = $ReturnableResult["OrderID"];
        print($gebruikersWachtwoord);
    }



        //echo "<script>window.location = 'login.php?Login=goed'</script>";
        break;
    }
    else if ($ReturnableResult["username"] != $gebruikersNaam && $ReturnableResult["password"] != $gebruikersWachtwoord ){
        //echo "<script>window.location = 'login.php?Login=fout'</script>";
        // print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
    }
}




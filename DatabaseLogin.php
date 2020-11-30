<?php

include "connect.php";

//PREPARE ALL VARIABLES
$gebruikersNaam = "";
$gebruikersWachtwoord = "";


//CHECK IF DATA IS SET
if (isset($_POST["Username"]) && isset($_POST["Password"])){
    $gebruikersNaam = $_POST["Username"];
    $gebruikersWachtwoord = $_POST["Password"];
}


//CONVERT PASSWORD TO HASH
$gebruikersWachtwoord = hash("SHA256", $gebruikersWachtwoord);;

//PULL DATA FROM DATABASE TO COMPARE
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

//FOR EVERY ROW IN THE RESULT, CHECK IF INPUT IS SAME AS DATA IN DATABASE AND SAVE IN SESSION
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
    }

//GO BACK
        echo "<script>window.location = 'login.php?Login=goed'</script>";
        break;
    }

//IF INPUT IS INCORRECT, GO BACK AND GIVE ERROR
    else if ($ReturnableResult["username"] != $gebruikersNaam && $ReturnableResult != $gebruikersWachtwoord ){
       echo "<script>window.location = 'login.php?Login=fout'</script>"; 
    }
}




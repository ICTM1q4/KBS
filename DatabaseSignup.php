<?php

$gebruikersNaam = "";
$gebruikersWachtwoord = "";

$gebruikersNaam = $_POST["Username"];
$gebruikersWachtwoord = $_POST["Password"];

$Query = "
                


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);


if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
    print("<h1> Welkom $ReturnableResult['firstname'] $ReturnableResult['lastname'], je bent zojuist ingelogd!</h1>");
    $_SESSION["loggedin"] == true;
}
else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}



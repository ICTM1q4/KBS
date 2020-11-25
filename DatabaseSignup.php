<?php
include "connect.php";
$gebruikersNaam = "";
$gebruikersWachtwoord = "";
$gebruikersFirstNaam = "";
$gebruikersLastNaam = "";
$gebruikersAddress = "";
$gebruikersZipcode = "";
$gebruikersPhone = "";
$gebruikersEmail = "";



$gebruikersNaam = $_POST["Username"];
$gebruikersWachtwoord = $_POST["Password"];

if (isset($_POST["phonenumber"])){
    $Query = "INSERT INTO webcustomer (FirstName,LastName,Username,Password,Address,Zipcode,Phonenumber,Email)
    VALUES (?,?,?,?,?,?,?,?);";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "isisisis", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersPhone, $gebruikersEmail);


}
else {
    $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,emailaddress)
    VALUES (?,?,?,?,?,?,?);";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "isisisis", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail); 
}

                


    
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);


if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
    print("<h1> Welkom". $ReturnableResult['firstname'] . $ReturnableResult['lastname'].", je bent zojuist ingelogd!</h1>");
    $_SESSION["loggedin"] == true;
}
else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}



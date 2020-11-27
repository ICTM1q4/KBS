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

$gebruikersNaam = mysqli_real_escape_string($Connection, $_POST["Username"]);
$gebruikersWachtwoord = mysqli_real_escape_string($Connection, $_POST["Password"]);
$gebruikersFirstNaam = mysqli_real_escape_string($Connection, $_POST["firstname"]);
$gebruikersLastNaam = mysqli_real_escape_string($Connection, $_POST["lastname"]);
$gebruikersAddress = mysqli_real_escape_string($Connection, $_POST["address"]);
$gebruikersZipcode = mysqli_real_escape_string($Connection, $_POST["zipcode"]);
$gebruikersPhone = mysqli_real_escape_string($Connection, $_POST["phonenumber"]);
$gebruikersEmail = mysqli_real_escape_string($Connection, $_POST["email"]);

if (isset($_POST["phonenumber"])){
        $Query ="INSERT INTO webcustomer (Firstname,Lastname,Username,Password,Address,Zipcode,Phonenumber,Email)
        VALUES ('$gebruikersFirstNaam', '$gebruikersLastNaam', '$gebruikersNaam', '$gebruikersWachtwoord','$gebruikersAddress','$gebruikersZipcode','$gebruikersPhone','$gebruikersEmail');";
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "isisisis", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersPhone, $gebruikersEmail);

        mysqli_stmt_execute($Statement);
    }

else {
    $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,email)
    VALUES (?,?,?,?,?,?,?);";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "isisisis", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail); 
}

$Queryun= mysqli_query($Connection, "SELECT Username FROM webcostumer WHERE Username LIKE" . mysqli_real_escape_string($Connection, $_POST['Username']) . ";");
if($_POST["Username"] == $Queryun){
    print("Huge Succ");
}

else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}
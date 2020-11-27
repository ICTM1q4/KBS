<?php
include "connect.php";

$gebruikersNaam = mysqli_real_escape_string($Connection, $_POST["Username"]);
$gebruikersWachtwoord = mysqli_real_escape_string($Connection, $_POST["Password"]);
$gebruikersFirstNaam = mysqli_real_escape_string($Connection, $_POST["firstname"]);
$gebruikersLastNaam = mysqli_real_escape_string($Connection, $_POST["lastname"]);
$gebruikersAddress = mysqli_real_escape_string($Connection, $_POST["address"]);
$gebruikersZipcode = mysqli_real_escape_string($Connection, $_POST["zipcode"]);
$gebruikersPhone = mysqli_real_escape_string($Connection, $_POST["phonenumber"]);
$gebruikersEmail = mysqli_real_escape_string($Connection, $_POST["email"]);

$uppercase = preg_match('@[A-Z]@', $gebruikersWachtwoord);
$lowercase = preg_match('@[a-z]@', $gebruikersWachtwoord);
$number    = preg_match('@[0-9]@', $gebruikersWachtwoord);
$specialChars = preg_match('@[^\w]@', $gebruikersWachtwoord);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($gebruikersWachtwoord) < 8) {
    print("Wachtwoord moet minimaal 8 karakters lang zijn en minimaal 1 hoofdletter, 1 cijfer en 1 speciaal karakter bevatten.");
} elseif (isset($_POST["phonenumber"])){
        $Query ="INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode, phonenumber, email)
        VALUES ('$gebruikersFirstNaam', '$gebruikersLastNaam', '$gebruikersNaam', '$gebruikersWachtwoord','$gebruikersAddress','$gebruikersZipcode','$gebruikersPhone','$gebruikersEmail');";
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "ssssssss", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersPhone, $gebruikersEmail);
        mysqli_stmt_execute($Statement);
    } else {
            $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,email)
            VALUES (?,?,?,?,?,?,?);";
            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "ssssssss", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail); 
            mysqli_stmt_execute($Statement);
}


?>
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
$gebruikersFirstNaam = $_POST["firstname"];
$gebruikersLastNaam = $_POST["lastname"];
$gebruikersAddress = $_POST["address"];
$gebruikersZipcode = $_POST["zipcode"];
$gebruikersPhone = $_POST["phonenumber"];
$gebruikersEmail = $_POST["email"];

//password check
$uppercase = preg_match('@[A-Z]@', $gebruikersWachtwoord);
$lowercase = preg_match('@[a-z]@', $gebruikersWachtwoord);
$number    = preg_match('@[0-9]@', $gebruikersWachtwoord);
$specialChars = preg_match('@[^\w]@', $gebruikersWachtwoord);
 
if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($gebruikersWachtwoord) < 8) {
    print("<script>window.location = 'Signup.php?ww=fout'</script>");
} 
else {
            $gebruikersWachtwoord = password_hash($gebruikersWachtwoord, PASSWORD_BCRYPT);
            $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,Email,Phonenumber)
            VALUES (?,?,?,?,?,?,?,?);";
            $Statement = mysqli_prepare($Connection, $Query);
             mysqli_stmt_bind_param($Statement, "ssssssss", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail, $gebruikersPhone); 
            mysqli_stmt_execute($Statement);
}
 



//CHECK IF DUPE
$Query = " SELECT DISTINCT Username FROM WebCustomer;";
    $Statement = mysqli_prepare($Connection, $Query);
    
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    foreach ($ReturnableResult as $ReturnableResult){
        if (isset($ReturnableResult["Username"])){
            if ($ReturnableResult["Username"] == $gebruikersNaam){
                print("<script>window.location = 'Signup.php?Registreer=fout'</script>;");
                break;
            }
        }
    }












                



    $Query = " SELECT Username, CustomerID FROM WebCustomer WHERE Username = ?; ";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $gebruikersNaam);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    foreach ($ReturnableResult as $ReturnableResult){
        if ($ReturnableResult["Username"] == $gebruikersNaam){
            $ID = $ReturnableResult["CustomerID"];
            $gebruikersNaam = $ReturnableResult["Username"];

            print("yes");
        }
        

        
    }

    

if($gebruikersNaam == $ReturnableResult["Username"]){
    print("Huge Succ");
    echo "<script>window.location = 'login.php'</script>";

    $Query = "
    INSERT INTO weborder (CustomerID)
    VALUES (?);";


$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $ID);
mysqli_stmt_execute($Statement);
$_SESSION["CustomerID"] = $ID;







}
// if ($ReturnableResult["Username"] == $gebruikersNaam && $ReturnableResult["Password"] == $gebruikersWachtwoord ){
//     print("Welkom". $ReturnableResult['firstname']. $ReturnableResult['lastname'].", je bent zojuist ingelogd!");
//     $_SESSION["loggedin"] == true;

else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}

// $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord,$gebruikersAddress,$gebruikersZipcode,$gebruikersPhone,$gebruikersEmail

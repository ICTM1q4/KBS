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





//INSERT INTO DATABASE
        $Query ="INSERT INTO webcustomer (Firstname,Lastname,Username,Password,Address,Zipcode,Phonenumber,Email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "ssssssss", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersPhone, $gebruikersEmail);

        mysqli_stmt_execute($Statement);





                


    // $Statement = mysqli_prepare($Connection, $Query);
    // mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    // mysqli_stmt_execute($Statement);
    // $ReturnableResult = mysqli_stmt_get_result($Statement);
    // $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
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

    


//$Queryun= mysqli_query($Connection, $Query);
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

<?php
<<<<<<< HEAD
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
    } else {
    $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,email)
    VALUES (?,?,?,?,?,?,?);";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "isisisis", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail); 
}

$Queryun= mysqli_query($Connection, "SELECT Username FROM webcostumer WHERE Username LIKE" . mysqli_real_escape_string($Connection, $_POST['Username']) . ";");
if($_POST["Username"] == $Queryun){
    print("Huge Succ");
} else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}
=======
    include "connect.php";

//PREPARE ALL VARIABLES
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
    $uppercase    = preg_match('@[A-Z]@', $gebruikersWachtwoord);
    $lowercase    = preg_match('@[a-z]@', $gebruikersWachtwoord);
    $number       = preg_match('@[0-9]@', $gebruikersWachtwoord);
    $specialChars = preg_match('@[^\w]@', $gebruikersWachtwoord);
    
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($gebruikersWachtwoord) < 8) {
        print("<script>window.location = 'Signup.php?registreer=fout'</script>");
    } 
 
//CHECK IF DUPE
    $Query = "
        SELECT DISTINCT Username 
        FROM WebCustomer;";

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

//INSERT DATA INTO DATABASE
    $gebruikersWachtwoord = hash("SHA256", $gebruikersWachtwoord);
    $Query = "INSERT INTO webcustomer (firstname,lastname,username,password,address,zipcode,Email,Phonenumber)
    VALUES (?,?,?,?,?,?,?,?);";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssssss", $gebruikersFirstNaam, $gebruikersLastNaam, $gebruikersNaam, $gebruikersWachtwoord, $gebruikersAddress, $gebruikersZipcode, $gebruikersEmail, $gebruikersPhone); 
    mysqli_stmt_execute($Statement);

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
//GO BACK AND SET SESSION ID
    
        $Query = "
        INSERT INTO weborder (CustomerID)
        VALUES (?);";

        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "i", $ID);
        mysqli_stmt_execute($Statement);
        $_SESSION["CustomerID"] = $ID;
        echo "<script>window.location = 'login.php'</script>";
    

>>>>>>> 5cea190212d45d7eac31d0ff7f6bf7719dc9b18e

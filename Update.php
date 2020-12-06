<?php
include ('connect.php');

$NPassword = '';
$NUsername = '';
$NFirstname = '';
$NLastname = '';
$NEmail = '';
$NPhone = '';
$NAddress = '';
$NZipcode = '';

if(isset($_POST['Password']){
    $NPassword = $_POST['Password'];
}
if(isset($_POST['Username']){
    $NUsername = $_POST['Username'];
}
if(isset($_POST['Firstname']){
    $NFirstName = $_POST['Firstname'];
}
if(isset($_POST['Lastname']){
    $NLastName = $_POST['Lastname'];
}
if(isset($_POST['Address']){
    $NAddress = $_POST['Address'];
}
if(isset($_POST['Phonenumber']){
    $NPhone = $_POST['Phonenumber'];
}
if(isset($_POST['Postcode']){
    $NZipcode = $_POST['Postcode'];
}
if(isset($_POST['Email']){
    $NEmail = $_POST['Email'];
}


if (isset($_SESSION["Customer"])){
    $CustomerID = $_SESSION["Customer"];
}
else{
    $CustomerID = "";
}

$DNaam = "";
$DFirstName = "";
$DLastName = "";
$DPassword = "";
$DAddress = "";
$DZipcode = "";
$DPhonenumber = "";
$DEmail = "";


$Query = "
        SELECT *
        FROM webcustomer WC
        WHERE WC.CustomerID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $CustomerID);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    foreach($ReturnableResult as $Customer){
        $DNaam = $Customer['Username'];
        $DFirstName = $Customer['FirstName'];
        $DLastName = $Customer['LastName'];
        $DPassword = $Customer['Password'];
        $DAddress = $Customer['Address'];
        $DZipcode = $Customer['Zipcode'];
        $DPhonenumber = $Customer['Phonenumber'];
        $DEmail = $Customer['Email'];
        
    }

    if ($DPassword == $NPassword){









        
    }
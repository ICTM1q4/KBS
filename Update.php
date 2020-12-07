<?php
include ('connect.php');
session_start();
$NHPassword = '';
$NUsername = '';
$NFirstName = '';
$NLastName = '';
$NEmail = '';
$NPhone = '';
$NAddress = '';
$NZipcode = '';
$NNPassword = '';
if(isset($_POST['NWW']) && $_POST['NWW'] != ""){
    //password check
    $uppercase    = preg_match('@[A-Z]@', $_POST['NWW']);
    $lowercase    = preg_match('@[a-z]@', $_POST['NWW']);
    $number       = preg_match('@[0-9]@', $_POST['NWW']);
    $specialChars = preg_match('@[^\w]@', $_POST['NWW']);
    
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST['NWW']) < 8) {
        print("<script>window.location = 'bewerken.php?bewerken=fout'</script>");
    }
    else{ 
    $NNPassword = hash("SHA256", $_POST['NWW']);
    }
}
if(isset($_POST['HWW'])){
    $NHPassword = hash("SHA256", $_POST['HWW']);
}
if(isset($_POST['Username'])){
    $NUsername = $_POST['Username'];
}
if(isset($_POST['Firstname'])){
    $NFirstName = $_POST['Firstname'];
}
if(isset($_POST['Achternaam'])){
    $NLastName = $_POST['Achternaam'];
}
if(isset($_POST['Address'])){
    $NAddress = $_POST['Address'];
}
if(isset($_POST['Phonenumber'])){
    $NPhone = $_POST['Phonenumber'];
}
if(isset($_POST['Postcode'])){
    $NZipcode = $_POST['Postcode'];
}
if(isset($_POST['Email'])){
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

    if ($DPassword == $NHPassword){


        $Query = "
        UPDATE webcustomer
        SET FirstName = ?, LastName = ?, Username = ?, Address = ?, Zipcode = ?, Phonenumber = ?, Email = ?
        WHERE CustomerID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssssss", $NFirstName, $NLastName, $NUsername, $NAddress, $NZipcode, $NPhone, $NEmail, $CustomerID);
    mysqli_stmt_execute($Statement);
    

        if ($NHPassword != $NNPassword && $NNPassword != ""){
            $Query = "
        UPDATE webcustomer
        SET Password = ?
        WHERE CustomerID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ss", $NNPassword, $CustomerID);
    mysqli_stmt_execute($Statement);
    
        }




        
    }

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $position = strrpos($actual_link, "/");
            $count = strlen($actual_link);
            $positionChar = substr($actual_link, $position);
            while ($positionChar != ""){
                $actual_link = substr_replace($actual_link, "", $position);
                $positionChar = substr($actual_link, $position);
            }
            header('Location: ' . $actual_link . '/bewerken.php');
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    <link rel='stylesheet' href='CSS/contact.css'>
    <style>
    .bewerken input{
        border: white 10px solid;
    }
    
    
    
    
    </style>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<?php

include ('connect.php');

if (isset($_SESSION["Customer"])){
    $CustomerID = $_SESSION["Customer"];
}
else{
    $CustomerID = "";
}

$Naam = "";
$FirstName = "";
$LastName = "";
$Password = "";
$Address = "";
$Zipcode = "";
$Phonenumber = "";
$Email = "";


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
        $Naam = $Customer['Username'];
        $FirstName = $Customer['FirstName'];
        $LastName = $Customer['LastName'];
        $Password = $Customer['Password'];
        $Address = $Customer['Address'];
        $Zipcode = $Customer['Zipcode'];
        $Phonenumber = $Customer['Phonenumber'];
        $Email = $Customer['Email'];
        
    }
?>

<body style="background-attachment: fixed; height: 800px;">
    <div style="height: 90%; width: 80%; margin: auto; background-color: rgba(0,0,0,0.5); margin-top: 50px;">
    <h1 style="color: white; text-align: center;">Gegevens Bewerken</h1>
        <div style="padding-top: 50px; margin-left: auto; margin-right: auto; width: 60%;">
            <form class="bewerken" action="Update.php" method="post" style="color: white; ">
                <div style="width: 23%; float: left; margin-left: 0px; background-color: rgba(255,255,255,0.3);"> <!-- Namen veranderen -->
                    <table>
                        <tr>
                            <td style="padding-bottom: 0px;">
                            <label for="Username">Gebruikersnaam:</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;">
                                <input type="text" name="Username" id="Username" style="color: black; width: 100%;" value="<?php print($Naam);?>" >
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 0px;">
                            <label for="Firstname">Voornaam:</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;">
                            <input type="text" name="Firstname" id="Firstname" value="<?php print($FirstName);?>" style="width: 100%;">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 0px;">
                            <label for="Achternaam">Achternaam:</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;">
                            <input type="text" name="Achternaam" id="Achternaam" value="<?php print($LastName);?>" style="width: 100%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="width: 23%; margin-left: 2%; margin-right: auto; float: left; background-color: rgba(255,255,255,0.3); height: 294px;">  <!-- WW veranderen -->
                    <table>
                        <tr>
                            <td style="padding-bottom: 0px;">
                            <label for="HWW">Huidige wachtwoord:</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;">
                            <input required="required" type="password" name="HWW" id="HWW" value="" style="width: 100%;">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 0px;">
                            <label for="NWW">Nieuw wachtwoord:</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;">
                            <input type="password" name="NWW" id="NWW" value="" style="width: 100%;">
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="float: right; width: 46%; float: left; margin-right: 0px; margin-left: 2%; background-color: rgba(255,255,255,0.3); height: 294px;"> <!-- Overige persoonlijke gegevens veranderen -->
                <table>
                    <tr>
                    <td style="padding-bottom: 0px;">
                        <label for="Address">Address:</label>
                        </td>
                        <td style="padding-bottom: 0px;">
                        <label for="Postcode">Postcode:</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 0px;">
                            <input type="text" name="Address" id="Address" style="color: black; width: 100%;" value="<?php print($Address);?>" >
                        </td>
                        <td style="padding-top: 0px;">
                        <input type="text" name="Postcode" id="Postcode" value="<?php print($Zipcode);?>" style="width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 0px;">
                        <label for="Email">Email:</label>
                        </td>
                        <td style="padding-bottom: 0px;">
                        <label for="Phonenumber">Phonenumber:</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 0px;">
                        <input type="text" name="Email" id="Email" value="<?php print($Email);?>" style="width: 100%;">
                        </td>
                        <td style="padding-top: 0px;">
                        <input type="text" name="Phonenumber" id="Phonenumber" value="<?php print($Phonenumber);?>" style="width: 100%;">
                        </td>
                    </tr>
                </table>
                </div> <br> <br><br><br><br><br><br><br><br><br><br><br><br>
                <p style="color: white;">Voor het wijzigen van je gegevens, is je huidige wachtwoord verplicht.</p>
                <input type="submit" value="Bewerken" style="margin-top: 80px; margin-left: 40%; margin-right: 40%; width: 20%">
            </form>
        </div>
    </div>
</body>

<footer style="margin-top: -20px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>

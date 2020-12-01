<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
    NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    

</head>

<?php
include "connect.php";
// $Query = " 
// ;";


// $Statement = mysqli_prepare($Connection, $Query);
// mysqli_stmt_bind_param($Statement, "s", $_SESSION["CustomerID"]);
// mysqli_stmt_execute($Statement);
// $ReturnableResult = mysqli_stmt_get_result($Statement);
// $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);



?>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>
<div> 
<br>
<br>
<?php 
if (isset($_POST["price"])){
    if ($_POST["price"] != "0.00"){
        $totaalprijs = $_POST["price"];
        print("<p style='color: white; font-family: Calibri; margin: auto; text-align: center; font-size: 150%;'>Totaalprijs van de bestelling is: €$totaalprijs</p>");
    }
    else if ( $_POST["price"] == "0.00"){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $position = strrpos($actual_link, "/");
        $count = strlen($actual_link);
        $positionChar = substr($actual_link, $position);
        while ($positionChar != ""){
            $actual_link = substr_replace($actual_link, "", $position);
            $positionChar = substr($actual_link, $position);
        }
        header('Location: ' . $actual_link . '/winkelmand.php?bestelling=fout');   
    }
}

?>
</div>
<!-- Het adress-->
<div>
<form action="" style="margin-left: 35%; margin-top: 3%; width: 30%;">
<div style="border: black solid 3px; background-color: white;">

<input type="radio" name="Address" id="Address1" style="margin-left: 5px;">
<label for="Address1">Opgeslagen:</label>
<p style="margin-left: 20px;">Address: <?php print($_SESSION["Address"]) ?> </p>
<p style="margin-left: 20px;">Zipcode: <?php print($_SESSION["Zip"]) ?> </p>
</div>
<br>
<br>
<div style="border: black solid 3px; background-color: white;">
<input type="radio" name="Address" style="margin-left: 5px;"> <br>
<label for="ADD" style="margin-left: 20px; ">Address:</label>
<input type="text" name="AddressCustom" id="ADD" placeholder="Straat"> <br>
<label for="ZIP" style="margin-left: 20px; ">Zipcode:</label>
<input type="text" name="ZipCustom" id="ZIP" style="margin-bottom: 10px;" placeholder="7951AA"> <br>
</div>
<input type="submit" style="width: 150px; height: 50px; background-color: rgb(0,200,0); color: white; border: 5px solid rgb(0,180,0); border-radius: 3px; margin-top: 10px; margin-left: 180px;" value="Bestelling Afronden">
</form>



</div>

<body>



</body>
<?php
include __DIR__ . "/Footer.php";
?>
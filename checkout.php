<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
</head>

    <?php
        include "connect.php";
    ?>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<body style="background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
    <div> 
        <br>
        <br>
        <?php 
            if (isset($_POST["price"])){
                if ($_POST["price"] != "0.00"){
                    $totaalprijs = $_POST["price"];
                    print("<p style='color: white; font-family: Calibri; margin: auto; text-align: center; font-size: 150%;'>Totaalprijs van de bestelling is: " sprintf("€%0.2f", number_format($totaalprijs, 2)); "</p>");
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
        <form action="Betalen.php" style="margin-left: 35%; margin-top: 3%; width: 30%;" method='post'>
            <div style="border: black solid 3px; background-color: white;">
                <label for="Address1">Opgeslagen:</label>
                <input type="radio" name="Address" id="Address1" style="margin-left: 5px;">  
                <p style="margin-left: 20px;">Address: <?php print($_SESSION["Address"]) ?> </p>
                <p style="margin-left: 20px;">Zipcode: <?php print($_SESSION["Zip"]) ?> </p>
            </div>
            <br>
            <br>
            <div style="border: black solid 3px; background-color: white;">
                <input type="radio" name="Address" style="margin-left: 5px;"> 
                <br>
                <label for="ADD" style="margin-left: 20px; ">Address:</label>
                <input type="text" name="AddressCustom" id="ADD" placeholder="Straat"> 
                <br>
                <label for="ZIP" style="margin-left: 20px; ">Zipcode:</label>
                <input type="text" name="ZipCustom" id="ZIP" style="margin-bottom: 10px;" placeholder="7951AA"> 
                <br>
            </div>
            <input type="hidden" value="<?php print($totaalprijs); ?>" name='price' id='price'>
            <input type="submit" style="width: 150px; height: 50px; background-color: rgb(0,200,0); color: white; border: 5px solid rgb(0,180,0); border-radius: 3px; margin-top: 10px; margin-left: 180px;" value="Bestelling Afronden">
        </form>
    </div>
</body>

<footer>
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>

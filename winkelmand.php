<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NerdyGadgets</title>
    <link rel='stylesheet' href='CSS/style.css'>
    <script>
    var ID = "<?php print($ID);?>";
    function myAjax() {
        $.ajax({
           type: "POST",
           url: 'http://localhost:83/Github/KBS-1/winkelmand.php/Delete.php',
           data:{ID: ID},
           success:function(html) {
             alert(html);
           }
        });
    }
    </script>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<body style="color: white; background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
    <div id="winkelmandje" style="margin-top: 20px; margin-left: 30px;">
        <h1>Uw winkelmand </h1>
        <?php
            $Statement = "";
//totaalprijs berekenen:
            $Query = "
                SELECT DISTINCT SUM(WO.Price) as SellPrice, OrderLineID
                FROM WebOrderline WO
                LEFT JOIN stockitems SI ON WO.stockitemID = SI.stockitemid
                WHERE OrderID = ?;";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "s", $_SESSION["OrderID"]);
            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
            foreach($ReturnableResult as $ReturnableResult){
                $totaal = $ReturnableResult["SellPrice"];
            }

//alles ophalen uit database
            $Query = "
                SELECT DISTINCT SI.StockItemName as Product, WO.StockItemID as ProductID, WO.OrderAmount as Amount, WO.Price as SellPrice, (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as Image, WO.OrderLineID as ID, 
                (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                FROM WebOrderline WO
                LEFT JOIN stockitems SI ON WO.stockitemID = SI.stockitemid
                LEFT JOIN stockitemimages SII ON SI.stockitemID = SII.stockitemID
                WHERE OrderID = ?";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "s", $_SESSION["OrderID"]);
            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
        ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 100px;">
                    </th>
                    <th style="width: 700px;">
                        Product
                    </th>
                    <th>
                        Artikelnummer
                    </th>
                    <th>
                        Aantal
                    </th>
                    <th>
                        Prijs
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $switch = 1;
                    $totaal = 0;
                    foreach ($ReturnableResult as $row){ 
                        if (isset($row['Image'])){
                            $ImageLine = "Public/StockItemIMG/".$row['Image'];
                            $switch = 0;
                        }
                        else{
                            $ImageLine = "Public/StockGroupIMG/".$row['BackupImagePath'];
                            $switch = 0;
                        }
                        $totaal += $row['SellPrice'] * $row['Amount'];
                        print("<tr style='text-align: center; '>");
                        print("<td><img src='$ImageLine' style='width: 80px; height:80px;'> </td>"); //image
                        print("<td><h1 style='font-size: 150%;'>". $row['Product'] ."</h1> </td>") ; //artikelnaam
                        print("<td><p style='color: white;'>".$row['ProductID']."</p> </td>"); //artikelcode
                        ?> 
                        <td style='padding-top: 0px; padding-bottom: 20px;'>
                            <form action="Amount.php">
                                <input type="hidden" name="change" value="plus">
                                <input type="hidden" name="url" value="<?php print($_GET['url'])?>">
                                <input type="hidden" name="OrderLine" value="<?php print($row["ID"]); ?>">
                                <button type='submit' style='border: solid black; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; transform: rotate(-135deg); -webkit-transform: rotate(-135deg); background-color: #463886;'>
                                </button>
                            </form>
                            <p style='color: white; margin-bottom: -10px;'><?php print($row['Amount']); ?> </p>
                            <form action="Amount.php">
                                <input type="hidden" name="change" value="minus">
                                <input type="hidden" name="url" value="<?php print($_GET['url'])?>">
                                <input type="hidden" name="OrderLine" value="<?php print($row["ID"]); ?>">
                                <button style='border: solid black; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; transform: rotate(45deg); -webkit-transform: rotate(45deg); background-color: #463886;'>
                                </button> 
                            </form>
                        </td>
                        <?php
                        print("<td><p style='color: white;'>€". number_format(($row['SellPrice'] * $row['Amount']),2). "</p></td>"); //artikelprijs
                        ?> 
                        <td>
                            <form action="Delete.php" method="post"> 
                            <input type="hidden" name="url" value="<?php print($_GET['url'])?>">
                                <input type="hidden" name="ID" value="<?php print($row['ID']); ?>" >
                                </input>
                                <input style="background-color: rgb(220,0,0); border: none; color: white; padding: 5px 13px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; margin-top: -10px; cursor: pointer; border-radius: 40px; border: 5px solid rgb(180,0,0)" type="submit" value="X"> 
                            </form>
                        </td> <?php
                        print("</tr>");
                }
                if (isset($_GET["bestelling"])){
                    if ($_GET["bestelling"] == "fout"){
                        ?>
                        
                        <p style='color: rgb(200,0,0);'>Er zit nog niks in je winkelmand!</p>
                        <?php
                    }
                }
                if ($switch != 0){
                    ?>
                    <tr style='text-align: center; height: 100px;'>
                        <td></td>
                        <td><h1 style='font-size: 150%;'></h1> </td>
                        <td><p style='color: white;'></p> </td>
                        <td><p style='color: white;'></p></td>
                        <td><p style='color: white;'></p></td>
                    </tr>
                    <?php 
                }
            ?>
            </tbody>
            <tfoot style="text-align: center;">
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        Totaalprijs:
                    </td>
                    <td>
                        <p style="margin-bottom: 0px;">
                            <?php print ("€".number_format($totaal,2));?>
                        </p>
                    </td>
                    <td>
                    </td>
                </tr>
            </tfoot>
        </table>
        <form action="<?php if(isset($_GET['url'])){
                if ($_GET['url']){
                    print($_GET['url']);
                }
            } else {
                print('index.php');
            }?>" method="post" style="float: left;">
            <button type="submit" style="background-color: rgb(0,220,0); border: none; color: white; padding: 5px 13px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px; border: 5px solid rgb(0,180,0); margin-left: 650px;">
                Verder Winkelen
            </button> 
        </form>
        <form action="checkout.php" method="post" style="float: left;">
            <input type="hidden" name="price" value="<?php print(number_format($totaal,2))?>">
            <button type="submit" style="background-color: rgb(0,220,0); border: none; color: white; padding: 5px 13px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px; border: 5px solid rgb(0,180,0); margin-left: 10px;">
                Afrekenen
            </button> 
        </form>
    </div>
</body>

<footer style="margin-top: 450px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>

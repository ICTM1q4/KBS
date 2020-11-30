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
<body style="color: white;">
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
<tr><th></th><th>Product</th><th>Artikelnummer</th><th>Aantal</th><th>Prijs</th></tr>

<?php
foreach ($ReturnableResult as $row){
if (isset($row['Image'])){
    $ImageLine = "Public/StockItemIMG/".$row['Image'];
}
else{
    $ImageLine = "Public/StockGroupIMG/".$row['BackupImagePath'];
}


    
    print("<tr style='text-align: center; '>");
    print("<td><img src='$ImageLine' style='width: 80px; height:80px;'> </td>"); //image
    print("<td><h1 style='font-size: 150%;'>". $row['Product'] ."</h1> </td>") ; //artikelnaam
    print("<td><p style='color: white;'>".$row['ProductID']."</p> </td>"); //artikelcode
    print("<td><p style='color: white;'>".$row['Amount']." </p></td>"); //artikelamount
    print("<td><p style='color: white;'>".$row['SellPrice']. "</p></td>"); //artikelprijs
    ?> <td><form action="Delete.php" method="post"> <input type="hidden" name="ID" value="<?php print($row['ID']); ?>" ></input><input style="background-color: rgb(220,0,0);
    border: none;
    color: white;
    padding: 5px 13px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px ;
    border: 5px solid rgb(220,0,0)" type="submit" value="Verwijderen"> </form></td> <?php
    print("</tr>");
}
print("</table>");




?>
<tr><td></td><td></td><td></td><td></td><td><p><?php print ($totaal);?></p></td></tr>
Totaalprijs:    25,98 Euro<br>
<button>Kopen die handel!</button>
</div>
</body>
<footer style="margin-top: 450px;">
<?php
include __DIR__ . "/Footer.php";
?>
</footer>

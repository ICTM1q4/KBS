<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    <link rel='stylesheet' href='CSS/contact.css'>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<?php
include "connect.php";

$CustomerID = $_SESSION['Customer'];

$Query = "
SELECT (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = WOL.StockItemID LIMIT 1) as BackupImagePath, SII.imagepath as Image, WO.Payment, WO.TotalPrice, WO.OrderDate, SI.StockItemName, WOL.OrderAmount, WOL.OrderID
FROM weborder WO
LEFT JOIN weborderline WOL ON WOL.OrderID = WO.OrderID
LEFT JOIN stockitems SI ON SI.StockItemID = WOL.StockItemID
LEFT JOIN stockitemimages SII ON SII.StockItemID = WOL.StockItemID
WHERE WO.Payment = 1
AND WO.CustomerID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $CustomerID);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

$Query = "
SELECT WO.Payment, WO.TotalPrice, WO.OrderDate, WO.OrderID
FROM weborder WO
WHERE WO.Payment = 1
AND WO.CustomerID = ?;";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "s", $CustomerID);
mysqli_stmt_execute($Statement);
$Product = mysqli_stmt_get_result($Statement);
$Product = mysqli_fetch_all($Product, MYSQLI_ASSOC);
?>

<body style="background-attachment: fixed;">
     <div style="min-height: 430px; width: 80%; margin-left: auto; margin-right: auto; margin-top: 50px;">
        <?php foreach ($Product as $row){ 
             
            $old_date_timestamp = strtotime($row['OrderDate']);
            $new_date = date('d F Y', $old_date_timestamp); 
            
            
            ?>
        <div style=' margin-bottom: 50px;'>
            <form action="order.php" method='post'>
                <div style="height: 350px; width: 100%; background-color: rgba(255,255,255,0.3); color: white; border: 10px rgba(255,255,255,0.00) solid; border-radius: 5px;">
                <h1 style=''><span><?php print($new_date); ?></span><span style='font-size: 15px;'><?php print(' '.'    Bestelling Nr. '.$row['OrderID']); ?></span></h1>
                    <p><?php print("Totaalprijs is: €" . $row['TotalPrice']); ?></p>
                    <table style='height: 50px;'>
                    <tr>
                        <?php foreach ($ReturnableResult as $R){
                            if ($R['OrderID'] == $row['OrderID']){
                            if ($R['Image'] != ''){
                                $image = 'Public/StockItemIMG/' . $R['Image'];
                            }
                            else {
                                $image = 'Public/StockGroupIMG/' . $R['BackupImagePath'];
                            }
                            
                            ?>
                            <td style='height:120px; width: 120px;'>
                            <img src="<?php print($image); ?>" alt="" style='height: 60px; width: 60px; object-fit: cover; margin-left: 30px; margin-right: 30px;'><br>
                            <p style='margin-left: 5px;'><?php print($R['StockItemName']); ?></p> 
                            <p style='text-align: center;'><?php print('x' . $R['OrderAmount']); ?></p>
                            </td>
                            <?php }} ?>
                            </tr>
                    </table>
                    <input type="hidden" name='order' id='order' value="<?php print($row['OrderID']); ?> ">
                <!-- <input type="submit" value='Bekijken' style='float: right; width: 100px; color: white; background-color: rgb(0,180,0); border: 3px solid rgb(0,180,0); border-radius: 2px;'> -->
                </div>
                
            </form>
            </div>
        <?php } ?>
     </div>
</body>

<footer style="margin-top: 240px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>




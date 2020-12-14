<!DOCTYPE html>
<html lang="en">
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
        SELECT WWL.Price, WWL.Description, WWL.StockItemID, SI.StockItemName, SI.MarketingComments, 
        (CASE WHEN (SIH.QuantityOnHand) >= 1000 THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
        (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
        (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
        FROM webwishlistline WWL
        JOIN webwishlist WW ON WW.WishListID = WWL.WishListID
        JOIN stockitems SI ON WWL.StockItemID = SI.StockItemID
        JOIN stockitemholdings SIH ON SI.StockItemID = SIH.StockItemID
        WHERE WW.CustomerID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $CustomerID);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    $counter = 0;
?>


<body style="height: 100%; background-attachment: fixed;">

<div style="min-height: 430px; width: 80%; margin-left: auto; margin-right: auto; margin-top: 50px;">
<h1 style="color: white;">Verlanglijst:</h1>
<?php foreach ($ReturnableResult as $row) {
            $counter++?>
            
            <a class="ListItem"  >
                <div id="ProductFrame" style="background-color: rgba(255,255,255,0.3);" >
                <a href='view.php?id=<?php print $row['StockItemID']; ?>' style="text-decoration: none;">
                    <?php
                    if (isset($row['ImagePath'])) { ?>
                        <div class="ImgFrame" href='view.php?id=<?php print $row['StockItemID']; ?>' 
                             style="background-image: url('<?php print "Public/StockItemIMG/" . $row['ImagePath']; ?>'); text-decoration: none; background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php } else if (isset($row['BackupImagePath'])) { ?>
                        <div class="ImgFrame" href='view.php?id=<?php print $row['StockItemID']; ?>'
                             style="background-image: url('<?php print "Public/StockGroupIMG/" . $row['BackupImagePath'] ?>'); text-decoration: none; background-size: cover;"></div>
                    <?php }
                    ?>
                    </a>

                    <div id="StockItemFrameRight">
                        <div class="CenterPriceLeftChild">
                            <h1 class="StockItemPriceText"><?php print sprintf("€ %0.2f", $row["Price"]); ?></h1>
                            <h6>Inclusief BTW </h6>
                            <div style="margin-top: 30px;">
                            <form action="AddWishList.php" style="margin-bottom: 5px; margin-right: 20px;">
                            <input type="hidden" name="product" value="<?php print($row['StockItemID']); ?>">
                            <style type="text/css">
                                .fabutton {
                                    background: none;
                                    padding: 0px;
                                    border: none;
                                }
                            </style>
                            
                            <button class="fabutton" type="submit" style="  background-color: none; border: none; color: white; font-family: Calibri; font-weight: bold;"  value=""><i class="fa">&#xf004;</i></button>
                            
                            
                            </form>
                            <form style="margin-top: 10px;" action="Toevoegen.php?product=<?php print($row['StockItemID'] . "&url=" . $actual_link); ?>">
                            <input type="hidden" name="product" value="<?php print($row['StockItemID']); ?>">
                            <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                            <input type="hidden" name="url" value="<?php print($actual_link); ?>">
                            <input type="submit" class="toevoegen" style="  background-color: #85bf31; border: 5px solid #85bf31; border-radius: 3px; color: white; font-family: Calibri; font-weight: bold;" value="Toevoegen aan winkelmand" ></input>
                            </form>
                            
                            </div>
                            
                        </div>
                    </div>
                    <a href='view.php?id=<?php print $row['StockItemID']; ?>' style="text-decoration: none;">
                    <h1 class="StockItemID">Artikelnummer: <?php print $row["StockItemID"]; ?></h1>
                    <p class="StockItemName"><?php print $row["StockItemName"]; ?></p>
                    <p class="StockItemComments"><?php print $row["MarketingComments"]; ?></p>
                    
                    <h4 class="ItemQuantity"><?php print $row["QuantityOnHand"]; ?>
                    </h4>
                    </a>
                </div>
                
            </a>
            
        <?php }  if($counter == 0) {print("<h2 style='color: white; text-align: center; margin-top: 50px;'>Je hebt nog niks in je verlanglijst staan!</h2>");}?>
</div>     
</body>

<footer style="padding-top: 315px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>
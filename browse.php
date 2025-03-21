<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>NerdyGadgets</title>
    <link rel='stylesheet' href='CSS/style.css'>
</head>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>



<body style="height: 100%; background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
    <?php
$SearchString = "";
$ReturnableResult = null;
if (isset($_GET['search_string'])) {
    $SearchString = $_GET['search_string'];
}
if (isset($_GET['category_id'])) {
    $CategoryID = $_GET['category_id'];
} else {
    $CategoryID = "";
}
if (isset($_GET['sort'])) {
    $SortOnPage = $_GET['sort'];
    $_SESSION["sort"] = $_GET['sort'];
} else if (isset($_SESSION["sort"])) {
    $SortOnPage = $_SESSION["sort"];
} else {
    $SortOnPage = "price_low_high";
    $_SESSION["sort"] = "price_low_high";
}

if (isset($_GET['products_on_page'])) {
    $ProductsOnPage = $_GET['products_on_page'];
    $_SESSION['products_on_page'] = $_GET['products_on_page'];
} else if (isset($_SESSION['products_on_page'])) {
    $ProductsOnPage = $_SESSION['products_on_page'];
} else {
    $ProductsOnPage = 25;
    $_SESSION['products_on_page'] = 25;
}
if (isset($_GET['page_number'])) {
    $PageNumber = $_GET['page_number'];
} else {
    $PageNumber = 0;
}

$AmountOfPages = 0;
$queryBuildResult = "";
switch ($SortOnPage) {
    case "price_high_low":
    {
        $Sort = "SellPrice DESC";
        break;
    }
    case "name_low_high":
    {
        $Sort = "StockItemName";
        break;
    }
    case "name_high_low";
        $Sort = "StockItemName DESC";
        break;
    case "price_low_high":
    {
        $Sort = "SellPrice";
        break;
    }
    default:
    {
        $Sort = "SellPrice";
        $SortName = "price_low_high";
    }
}
$searchValues = explode(" ", $SearchString);

$queryBuildResult = "";
if ($SearchString != "") {
    for ($i = 0; $i < count($searchValues); $i++) {
        if ($i != 0) {
            $queryBuildResult .= "AND ";
        }
        $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
    }
    if ($queryBuildResult != "") {
        $queryBuildResult .= " OR ";
    }
    if ($SearchString != "" || $SearchString != null) {
        $queryBuildResult .= "SI.StockItemID ='$SearchString'";
    }
}

$Offset = $PageNumber * $ProductsOnPage;

$ShowStockLevel = 1000;
if ($CategoryID == "") {
    if ($queryBuildResult != "") {
        $queryBuildResult = "WHERE " . $queryBuildResult;
    }

    $Query = "
                SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
                (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand, 
                (SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                FROM stockitems SI
                JOIN stockitemholdings SIH USING(stockitemid)
                " . $queryBuildResult . "
                GROUP BY StockItemID
                ORDER BY " . $Sort . " 
                LIMIT ?  OFFSET ?";


    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "iii", $ShowStockLevel, $ProductsOnPage, $Offset);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    $Query = "
            SELECT count(*)
            FROM stockitems SI
            $queryBuildResult";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
} else {

    if ($queryBuildResult != "") {
        $queryBuildResult .= " AND ";
    }

    $Query = "
                SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, WW.StockItemID Wish,
                ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice, 
                (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
                (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath           
                FROM stockitems SI 
                JOIN stockitemholdings SIH USING(stockitemid)
                JOIN stockitemstockgroups USING(StockItemID)
                JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
                LEFT JOIN webwishlistline WW ON WW.StockItemID = SI.StockItemID
                WHERE " . $queryBuildResult . " ? IN (SELECT StockGroupID from stockitemstockgroups WHERE StockItemID = SI.StockItemID)
                GROUP BY StockItemID
                ORDER BY " . $Sort . " 
                LIMIT ? OFFSET ?";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "iiii", $ShowStockLevel, $CategoryID, $ProductsOnPage, $Offset);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

    $Query = "
                SELECT count(*)
                FROM stockitems SI 
                WHERE " . $queryBuildResult . " ? IN (SELECT SS.StockGroupID from stockitemstockgroups SS WHERE SS.StockItemID = SI.StockItemID)";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $CategoryID);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
}
$amount = $Result[0];
if (isset($amount)) {
    $AmountOfPages = ceil($amount["count(*)"] / $ProductsOnPage);
}
?>
<div id="FilterFrame" style="margin-left: 50px; border: 3px solid black;"><h2 class="FilterText"><i class="fas fa-filter"></i> Filteren </h2>
    <form>
        <div id="FilterOptions">
            <h4 class="FilterTopMargin"><i class="fas fa-search"></i> Zoeken</h4>
            <input type="text" name="search_string" id="search_string"
                   value="<?php print (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>"
                   class="form-submit">
            <h4 class="FilterTopMargin"><i class="fas fa-list-ol"></i> Aantal producten op pagina</h4>

            <input type="hidden" name="category_id" id="category_id"
                   value="<?php print (isset($_GET['category_id'])) ? $_GET['category_id'] : ""; ?>">
            <select name="products_on_page" id="products_on_page" onchange="this.form.submit()">>
                <option value="25" <?php if ($_SESSION['products_on_page'] == 25) {
                    print "selected";
                } ?>>25
                </option>
                <option value="50" <?php if ($_SESSION['products_on_page'] == 50) {
                    print "selected";
                } ?>>50
                </option>
                <option value="75" <?php if ($_SESSION['products_on_page'] == 75) {
                    print "selected";
                } ?>>75
                </option>
            </select>
            <h4 class="FilterTopMargin"><i class="fas fa-sort"></i> Sorteren</h4>
            <select name="sort" id="sort" onchange="this.form.submit()">>
                <option value="price_low_high" <?php if ($_SESSION['sort'] == "price_low_high") {
                    print "selected";
                } ?>>Prijs oplopend
                </option>
                <option value="price_high_low" <?php if ($_SESSION['sort'] == "price_high_low") {
                    print "selected";
                } ?> >Prijs aflopend
                </option>
                <option value="name_low_high" <?php if ($_SESSION['sort'] == "name_low_high") {
                    print "selected";
                } ?>>Naam oplopend
                </option>
                <option value="name_high_low" <?php if ($_SESSION['sort'] == "name_high_low") {
                    print "selected";
                } ?>>Naam aflopend
                </option>
            </select>
    </form>
</div>
            </div>
<div id="ResultsArea" class="Browse" style="margin-bottom: 700px; ">
    <?php
    if (isset($ReturnableResult) && count($ReturnableResult) > 0) {
        ?> <div style="margin-bottom: -550px; "> <?php
        foreach ($ReturnableResult as $row) {
            ?>
            
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
                    <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                    <div id="StockItemFrameRight">
                        <div class="CenterPriceLeftChild">
                        
                            <h1 class="StockItemPriceText"><?php print sprintf("€ %0.2f", number_format($row["SellPrice"], 2)); ?></h1>
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
                            <input type="hidden" name="url" value="<?php print($actual_link); ?>">
                            <button class="fabutton" type="submit" style="  background-color: none; border: none; color: white;  font-family: Calibri; font-weight: bold;"  value=""><i class="<?php if ($row['Wish'] != ""){print('fa');}else{print('far');}?>">&#xf004;</i></button>
                            
                            
                            </form>
                            <form style="margin-top: 10px;" action="Toevoegen.php?product=<?php print($row['StockItemID'] . "&url=" . $actual_link); ?>">
                            <input type="hidden" name="product" value="<?php print($row['StockItemID']); ?>">
                            
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
                    <p style="color: rgb(255,100,100); ">
                    <?php
                    $Query = "
                    SELECT COUNT(WOL.stockitemid) amount
                    FROM weborderline WOL
                    JOIN weborder WO ON WO.OrderID = WOL.OrderID
                    WHERE WOL.StockItemID = ?
                    AND WO.Payment = 0;;";
            
                    $Statement = mysqli_prepare($Connection, $Query);
                    mysqli_stmt_bind_param($Statement, "s", $row['StockItemID']);
                    mysqli_stmt_execute($Statement);
                    $ReturnableResult = mysqli_stmt_get_result($Statement);
                    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
                    if(isset($ReturnableResult)){
                        foreach($ReturnableResult as $rows){
                            $amountInCart = $rows['amount'];
                        }
                        if ($amountInCart != 0 && $amountInCart != 1){
                            print($amountInCart . " klanten hebben dit product in hun winkelmand.");
                        }
                        else if ($amountInCart != 0 && $amountInCart == 1){
                            print($amountInCart . " klant heeft dit product in zijn winkelmand.");
                        }
                    }
                    
                    ?></p>
                    <h4 class="ItemQuantity"><?php print $row["QuantityOnHand"]; ?>
                    
                    
                    
                    
                    
                    
                    </h4>
                    </a>
                </div>
                
            </a>
            
        <?php } ?>

        <form id="PageSelector">
            <input type="hidden" name="search_string" id="search_string"
                   value="<?php if (isset($_GET['search_string'])) {
                       print ($_GET['search_string']);
                   } ?>">
            <input type="hidden" name="category_id" id="category_id" value="<?php if (isset($_GET['category_id'])) {
                print ($_GET['category_id']);
            } ?>">
            <input type="hidden" name="result_page_numbers" id="result_page_numbers"
                   value="<?php print (isset($_GET['result_page_numbers'])) ? $_GET['result_page_numbers'] : "0"; ?>">
            <input type="hidden" name="products_on_page" id="products_on_page"
                   value="<?php print ($_SESSION['products_on_page']); ?>">
            <input type="hidden" name="sort" id="sort" value="<?php print ($_SESSION['sort']); ?>">

            <?php
            if ($AmountOfPages > 0) {
                for ($i = 1; $i <= $AmountOfPages; $i++) {
                    if ($PageNumber == ($i - 1)) {
                        ?>
                        <div id="SelectedPage"><?php print $i; ?></div><?php
                    } else { ?>
                        <button id="page_number" class="PageNumber" value="<?php print($i - 1); ?>" type="submit"
                                name="page_number"><?php print($i); ?></button>
                    <?php }
                }
            }
            ?>
        </form>
        </div>
        <?php
    } else {
        ?>
        <h2 id="NoSearchResults" style="color: white; font-family: Calibri; background: none; ">
            Yarr, er zijn geen resultaten gevonden.
        </h2>
        <?php
    }
    ?>
</div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
</html>
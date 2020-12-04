

<?php
    $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
    mysqli_set_charset($Connection, 'latin1');
    include __DIR__ . "/header.php";
    $Query = " 
            SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $ShowStockLevel = 1000;
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $ShowStockLevel,$_GET['id']);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    } 
    else {
        $Result = null;
    }

//Get Images
    $Query = "
        SELECT ImagePath
        FROM stockitemimages 
        WHERE StockItemID = ?";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);
    if ($R) {
        $Images = $R;
    }
?>
<div id="CenteredContent">
    <?php
        if ($Result != null) {
    ?>
    <div id="ArticleHeader">
        <?php
            if (isset($Images)) {
// print Single
                if (count($Images) == 1) {
                    ?>
                    <div id="ImageFrame" style="background-image: url('Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($Images) >= 2) { ?>
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $Images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $Result['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $Result["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $Result['StockItemName']; ?>
            </h2>
            <div class="QuantityText" style="color: white; font-family:Calibri;"><?php print $Result['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $Result['SellPrice']); ?></b></p>
                        <h6 style="color: white;"> Inclusief BTW </h6>
                        <form action="Toevoegen.php?product=<?php print($_GET["id"]); ?>">
                            <input type="hidden" name="product" value="<?php print($_GET["id"]); ?>">
                            <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                            <input type="hidden" name="url" value="<?php print($actual_link); ?>">
                            <input type="submit" class="toevoegen" style="  background-color: #85bf31; border: 5px solid #85bf31; border-radius: 3px; color: white; font-family: Calibri; font-weight: bold;" value="Toevoegen aan winkelmand" ></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription" style="color: white;">
            <h3 style="color: white; border: none;">Artikel beschrijving</h3>
            <p><?php print $Result['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications" style="color: white;">
            <h3 style="border: none;">Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($Result['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $Result['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
<body>

    <div class='rating' style='margin-top: -50px; margin-left: -530px'>
        <input type='radio' name='ster' id='ster1'><label for='ster1'></label>
        <input type='radio' name='ster' id='ster2'><label for='ster2'></label>
        <input type='radio' name='ster' id='ster3'><label for='ster3'></label>
        <input type='radio' name='ster' id='ster4'><label for='ster4'></label>
        <input type='radio' name='ster' id='ster5'><label for='ster5'></label>
</div>
<!-- <div class="rate">
    <input type="radio" id="star5" name="rate" value="5" />
    <label for="star5" title="text">5 stars</label>
    <input type="radio" id="star4" name="rate" value="4" />
    <label for="star4" title="text">4 stars</label>
    <input type="radio" id="star3" name="rate" value="3" />
    <label for="star3" title="text">3 stars</label>
    <input type="radio" id="star2" name="rate" value="2" />
    <label for="star2" title="text">2 stars</label>
    <input type="radio" id="star1" name="rate" value="1" />
    <label for="star1" title="text">1 star</label>
  </div> -->
<div>
    <form action="Reviewen.php?product=<?php print($_POST["review"]); ?>">
    <textarea required maxlength="300" type="text" id="review" name="review" style="margin-left: 230px; width: 30%; height: 300px; text-align: upper-left; border-top: 1px gray solid;"></textarea> <br>
                <input type="submit" id="submit" value="Versturen" style="margin-left: 230px; margin-top: 10px;">
            </div>   
<!-- review   -->
            <div id="StockItemSpecifications" style="color: white; margin-top: -260px; margin-left: 760px; width: 40%;">
                <h3 style="border: none;">Reviews</h3>
                <?php
                $CustomFields = json_decode($Result['CustomFields'], true);
                if (is_array($CustomFields)) { ?>
                    <table>
                    <thead>
                    <th>Username</th>
                    <th>Review</th>
                    </thead>
                    <?php
                    foreach ($CustomFields as $SpecName => $SpecText) { ?>
                        <tr>
                            <td>
                                <?php print $SpecName; ?>
                            </td>
                            <td>
                                <?php
                                if (is_array($SpecText)) {
                                    foreach ($SpecText as $SubText) {
                                        print $SubText . " ";
                                    }
                                } else {
                                    print $SpecText;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php }} ?>
                    </table>
                    </div>
</body>
<footer style="padding-top: 330px;">
<?php
include __DIR__ . "/Footer.php";
?>
</footer>

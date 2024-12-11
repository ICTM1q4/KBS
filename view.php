



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
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video, SI.IsChillerStock,
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
<body style="background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
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
            <div class="QuantityText"><?php print $Result['QuantityOnHand']; ?></div>
        </div>

        <div id="StockItemDescription" style="color: white;">
            <h3 style="color: white; border: none;">Artikel beschrijving</h3>
            <p><?php print $Result['SearchDetails']; ?></p>
            <?php if (isset($Result['Video'])) {
            ?>
            <form action='video.php' method='post'>
            <input type="hidden" value='<?php print $Result['Video']; ?>' id='video' name='video'>
                <input type="submit" style='width: 300px; height: 50px; color: white; background-color: rgb(100,100,200); border: 5px solid rgb(100,100,200); border-radius: 5px; font-family: Calibri;' value='video bekijken'>
            </form>
        <?php } ?>
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
<?php if ($Result['IsChillerStock'] == 1){ ?>
<div style='margin-top: 300px;'>
<?php
$sensor1 = '';
$sensor2 = '';
$sensor3 = '';
$sensor4 = '';

$Query = "
        SELECT Temperature, ColdRoomSensorNumber 
        FROM coldroomtemperatures
        ORDER BY RecordedWhen, ColdRoomSensorNumber;";

    $Statement = mysqli_prepare($Connection, $Query);
    
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
foreach ($ReturnableResult as $temp){
    if ($temp['ColdRoomSensorNumber'] == 1){
        $sensor1 = $temp['Temperature'];
    }
    if ($temp['ColdRoomSensorNumber'] == 2){
        $sensor2 = $temp['Temperature'];
    }
    if ($temp['ColdRoomSensorNumber'] == 3){
        $sensor3 = $temp['Temperature'];
    }
    if ($temp['ColdRoomSensorNumber'] == 4){
        $sensor4 = $temp['Temperature'];
    }
}
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawGauge);

    var gaugeOptions = {min: 0, max: 10, yellowFrom: 7, yellowTo: 8.5,
      redFrom: 8.5, redTo: 10, minorTicks: 5};
    var gauge;

    function drawGauge() {
      gaugeData = new google.visualization.DataTable();
      gaugeData.addColumn('number', 'Sensor 1');
      gaugeData.addColumn('number', 'Sensor 2');
      gaugeData.addColumn('number', 'Sensor 3');
      gaugeData.addColumn('number', 'Sensor 4');
      gaugeData.addRows(4);
      gaugeData.setCell(0, 0, <?php print($sensor1); ?>);
      gaugeData.setCell(0, 1, <?php print($sensor2); ?>);
      gaugeData.setCell(0, 2, <?php print($sensor3); ?>);
      gaugeData.setCell(0, 3, <?php print($sensor4); ?>);

      gauge = new google.visualization.Gauge(document.getElementById('gauge_div'));
      gauge.draw(gaugeData, gaugeOptions);
    }

    function changeTemp(dir) {
      gaugeData.setValue(0, 0, gaugeData.getValue(0, 0) + dir * 25);
      gaugeData.setValue(0, 1, gaugeData.getValue(0, 1) + dir * 20);
      gauge.draw(gaugeData, gaugeOptions);
    }
  </script>
  <h1 style='color: white; text-align: center;'>Actuele temperatuur:</h1>
 <div id="gauge_div" style="width:500px; height: 250px; margin-left: auto; margin-right: auto; "></div> 


<?php
$Query = "
SELECT Temperature, RecordedWhen
FROM coldroomtemperatures
WHERE ColdRoomSensorNumber = 1
ORDER BY RecordedWhen
LIMIT 144";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
$counter = 1;
?>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'X');
      data.addColumn('number', 'Sensor 1');
      

      data.addRows([
        [[0, 0, 0], 0]
          <?php foreach ($ReturnableResult as $temps){
            $date = $temps['RecordedWhen'];
            $old_date_timestamp = strtotime($date);
            $new_date = date('H, i, s', $old_date_timestamp);
         print(', [['.$new_date.'], '.$temps['Temperature'].']');   
         $counter++;
        }?> 
        
      ]);
      
      var options = {
        hAxis: {
          title: 'Tijd'
        },
        vAxis: {
          title: 'Temperatuur'
        },
        series: {
            0: { color: '#040404' },
          },
        backgroundColor: '#0277bd'
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));
      chart.draw(data, options);
    }
</script>
<h1 style='text-align: center; color: white;'>Temperatuur van de afgelopen 24 uur:</h1>
<div style='margin-left: auto; margin-right: auto; width: 1212px;'>
  <div id="chart_div1" style='width: 45%; float: left; border: 5px solid #43459d; border-radius: 5px; margin-left: auto; margin-right: auto;'></div>

  <?php
$Query = "
SELECT Temperature, RecordedWhen
FROM coldroomtemperatures
WHERE ColdRoomSensorNumber = 2
ORDER BY RecordedWhen
LIMIT 144";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
$counter = 1;
?>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'X');
      data.addColumn('number', 'Sensor 2');
      

      data.addRows([
        [[0, 0, 0], 0]
          <?php foreach ($ReturnableResult as $temps){
            $date = $temps['RecordedWhen'];
            $old_date_timestamp = strtotime($date);
            $new_date = date('H, i, s', $old_date_timestamp);
         print(', [['.$new_date.'], '.$temps['Temperature'].']');   
         $counter++;
        }?> 
        
      ]);
      
      var options = {
        hAxis: {
          title: 'Tijd'
        },
        vAxis: {
          title: 'Temperatuur'
        },
        series: {
            0: { color: '#040404' },
          },
        backgroundColor: '#0277bd'
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
      chart.draw(data, options);
    }
</script>


  <div id="chart_div2" style='width: 45%; float: left; border: 5px solid #43459d; border-radius: 5px; margin-left: auto; margin-right: auto;'></div>

  <?php
$Query = "
SELECT Temperature, RecordedWhen
FROM coldroomtemperatures
WHERE ColdRoomSensorNumber = 3
ORDER BY RecordedWhen
LIMIT 144";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
$counter = 1;
?>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'X');
      data.addColumn('number', 'Sensor 3');
      

      data.addRows([
        [[0, 0, 0], 0]
          <?php foreach ($ReturnableResult as $temps){
            $date = $temps['RecordedWhen'];
            $old_date_timestamp = strtotime($date);
            $new_date = date('H, i, s', $old_date_timestamp);
         print(', [['.$new_date.'], '.$temps['Temperature'].']');   
         $counter++;
        }?> 
        
      ]);
      
      var options = {
        hAxis: {
          title: 'Tijd'
        },
        vAxis: {
          title: 'Temperatuur'
        },
        series: {
            0: { color: '#040404' },
          },
        backgroundColor: '#0277bd'
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
      chart.draw(data, options);
    }
</script>


  <div id="chart_div3" style='width: 45%; float: left; border: 5px solid #43459d; border-radius: 5px; margin-left: auto; margin-right: auto;'></div>

  <?php
$Query = "
SELECT Temperature, RecordedWhen
FROM coldroomtemperatures
WHERE ColdRoomSensorNumber = 4
ORDER BY RecordedWhen
LIMIT 144";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
$counter = 1;
?>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'X');
      data.addColumn('number', 'Sensor 4');
      

      data.addRows([
         [[0, 0, 0], 0]
          <?php foreach ($ReturnableResult as $temps){
            $date = $temps['RecordedWhen'];
            $old_date_timestamp = strtotime($date);
            $new_date = date('H, i, s', $old_date_timestamp);
         print(', [['.$new_date.'], '.$temps['Temperature'].']');   
         $counter++;
        }?> 
        
      ]);
      
      var options = {
        hAxis: {
          title: 'Tijd'
        },
        
        vAxis: {
          title: 'Temperatuur'
        },
        series: {
            0: { color: '#040404' },
          },
        backgroundColor: '#0277bd'
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
      chart.draw(data, options);
    }
</script>


  <div id="chart_div4" style='width: 45%; float: left; border: 5px solid #43459d; border-radius: 5px; margin-left: auto; margin-right: auto;'></div>
  </div>
</div>
<?php } ?>
    <div style="height: 50%; width: 70%; margin-top: 330px; margin-left: auto; margin-right: auto; margin-top: 550px;">
        
<?php
include "connect.php";

$switch = 0;

$Query = "
        SELECT WR.CustomerID ID, WR.StockItemID Item
        FROM webreview WR
        WHERE WR.StockItemID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $_GET['id']);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

foreach($ReturnableResult as $row){
    if ($_SESSION['Customer'] == $row['ID']){
        $switch = 1;
    }
}


$Query = "
        SELECT WR.Rating Rating, WR.Beschrijving Beschrijving, WC.Username Naam, WR.CustomerID CustomerID, WR.StockItemID Stock
        FROM webreview WR
        JOIN webcustomer WC ON WR.CustomerID = WC.CustomerID
        WHERE WR.StockItemID = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $_GET['id']);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    $count = 0;
?>
        <table style="width: 100%;">
         
            
                <?php
                    foreach ($ReturnableResult as $row){
                        if ($count < 1){
                    ?> 
                    <thead style="background-color: #0277bd; text-align: center; ">
                        <tr >
                            <td>
                            <h1 style="font-size: 170%;"> Rating
                            </h1>
                            </td>
                            
                            <td>
                            <h1 style="font-size: 170%;"> Naam</h1>
                            </td>
                            <td>
                                <h1 style="font-size: 170%;">Beschrijving<h1>
                            </td>
                        </tr>
                    </thead>
         
                    <tbody>
                        <?php $count++;} ?>

                    <tr style="background-color: rgb(35, 40, 47); color: white; text-align: center; border-bottom: 5px black solid;">
                    <td>

                    <div>
                    <?php
                    $none = 5;
                    while ($row['Rating'] > 0){
                        $row['Rating']--;
                        print("<span class='fa fa-star' style='color: yellow'></span>");
                        $none--;
                    }
                    while ($none > 0){
                        $none--;
                        print("<span class='fa fa-star'></span>");

                    }
                    ?>
                    </div>
                    </td>
                    <td>
                    <?php print("<h1 style='font-size: 170%;'>" . $row['Naam'] . "</h1>");?>
                    </td>
                    <td>
                    <?php print("<h1 style='font-size: 170%; margin-top: 5px;'>" . $row['Beschrijving'] . "</h1>");?>
                    <?php if($row['CustomerID'] == $_SESSION['Customer']){?>
                        <form action="DeleteReview.php">
                        <input type="hidden" name="product" value="<?php print($row['Stock']); ?>">
                        <input type="submit" value="X" style="color: white; float: right; background-color: red; border: 10px red solid; border-radius: 50px; margin-top: -40px; height: 40px; width: 40px;">
                        </form>
                        <?php } ?>
                    </td>
                    </tr>
                <?php
                }

                ?>
            </tbody>
        </table>
        <?php if ($switch != 1){ ?>
        <div style="margin-top: 50px; background-color: rgb(35, 40, 47); width: 100%; <?php if(isset($_SESSION['Customer'])){print('height: 500px;');}else{print('height: 200px;');}?>  ">
        <div style="margin-left: 10px; width: 60%; margin-left: 20%; margin-right: 20%;"> <br>
        <h1 style="color: white; text-align: center;">Review aanmaken:</h1>
        <?php if(isset($_SESSION['Customer']) ){?>
            <form action="ReviewToevoegen.php" style="margin-left: 40px; margin-top: 40px;">
                <div style="width: 50%;">
                <style>
                
                ul{
                    padding: 0;
                    margin-top: -50px;
                    margin-left: -30px;
                }

                ul li{
                    list-style-type: none;
                    display: inline-block;
                    margin: 10px;
                    color: white;
                    
                    font-size: 25px !important;
                }
                ul li:hover, li:hover ~ li{
                    color: yellow;
                }
                
                input[type='radio']{
                    display: none;
                }
                
                ul li input[type='radio']:checked{
                    color: yellow;
                }
                li input:checked ~ label{
                    color: yellow;
                }
                input.active, input.secondary-active{
                    color: yellow;
                }
                
                </style>
                <script>
                    $('input').on('click',function(){
                        $('input').removeClass('active');
                        $('input').removeClass('secondary-active');
                        $(this).addClass('active');
                        $(this).nextAll().addClass('secondary-active');
                    })
                </script>
                <ul style="padding-top: 10px; margin-left: 60px; width: 110%;">
                <class="rating" >
                <li style="float: right;"><input type="radio" name="ratings" id="rating5" value="5"><label for="rating5"><i class='fa fa-star' aria-hidden="true" ></i></label>
                </li>
                <li style="float: right;"><input type="radio" name="ratings" id="rating4" value="4"><label for="rating4"><i class='fa fa-star' aria-hidden="true" ></i></label>
                </li>
                <li style="float: right;"><input type="radio" name="ratings" id="rating3" value="3"><label for="rating3"><i class='fa fa-star' aria-hidden="true" ></i></label>
                </li>
                <li style="float: right;"><input type="radio" name="ratings" id="rating2" value="2"><label for="rating2"><i class='fa fa-star' aria-hidden="true" ></i></label>
                </li>
                <li style="float: right;"><input type="radio" name="ratings" id="rating1" value="1"><label for="rating1"><i class='fa fa-star' aria-hidden="true" ></i></label>
                </li>
                
                </ul>
                </div>
                <label for="beschrijving" style="color: white; margin-top: 25px;">Tips/Tops:</label>
            <textarea type="text" maxlength="256" name="beschrijving" id="beschrijving" style="width: 100%; height: 200px; margin-top: 0px;"> </textarea>
            <input type="hidden" name="Product" value="<?php print($_GET['id']); ?>">
            <input type="submit" value="Versturen" style="margin-top: 10px; width: 18%; margin-left: 41%; margin-right: 41%; height: 3em; background-color: #85bf31; color: white; border: #85bf31 solid 1px;">
            </form>
            <?php } 
            else {
                print("<br> <h1 style='color: white; font-size: 150%; text-align: center;'> Je moet ingelogd zijn om een review te maken! </h1>");
            } ?>
        </div>
            
        </div>
        <?php } ?>
    </div>
</body>
<footer style="padding-top: 330px;">
<?php
include __DIR__ . "/Footer.php";
?>
</footer>

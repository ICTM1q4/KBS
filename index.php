<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
      NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
</head>

<header>
  <?php
    include __DIR__ . "/Header.php";
  ?>
</header>

<body style="height: 900px; ">
  <div id="index" style="height: 100%; color: white;">
    <h1 style="padding-left: 42%; color: inherit; margin-top: 30px;">Trending Items</h1> 
    <br>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" style="height: 100%; width: 950px; margin-left: auto; margin-right: auto; border: 20px; border-radius: 10px;">
          <div  class="carousel-item active " style="width: auto; height: auto; background-color: rgba(128,128,128,0.5);">
            <a href="view.php?id=93" style="text-decoration: none;color: inherit; border: 20px; border-radius: 10px; border: 20px; border-radius: 10px;">
              <img  class="d-block" src="Public\ProductIMGHighRes\580b57fbd9996e24bc43bf55.png" alt="First slide" style="width: 30%; height: 300px;">
              <div>
                <h1>"THE GU" RED SHIRT T-SHIRT (BLACK) M</h1>
              </div>
            </a>
          </div>
          <div class="carousel-item " style="width: 100%; height: auto; background-color: rgba(128,128,128,0.5); border: 20px; border-radius: 10px;">
            <a href="view.php?id=2" style="text-decoration: none;border: 20px; border-radius: 10px; color: inherit;" >  
              <img class="d-block" src="Public\ProductIMGHighRes\usb.png" alt="First slide" style="width: 30%; height: 270px; margin-bottom: 15px; margin-top: 15px; margin-left: 20px; margin-right: 10px; padding-right:">
              <div>
                <h1 style="color: inherit;">USB ROCKET LAUNCHER (GRAY)</h1>
              </div>
            </a>
          </div>
          <div class="carousel-item " style="width: auto; height: auto; background-color: rgba(128,128,128,0.5); border: 20px; border-radius: 10px;">
            <a href="view.php?id=102" style="text-decoration: none; color: inherit;">
              <img class="d-block" src="Public\ProductIMGHighRes\Hoodie.png" alt="First slide" style="width: 30%; height: 300px;">
              <div>
                <h1 style="color: inherit;">ALIEN OFFICER HOODIE (BLACK)</h1>
              </div>
            </a>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="margin-bottom: 50px; margin-left: 150px;">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" style="margin-bottom: 50px; margin-right: 150px;">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <?php
      $Query = "
        SELECT StockGroupID, StockGroupName, ImagePath
        FROM stockgroups 
        WHERE StockGroupID IN (
                          SELECT StockGroupID 
                          FROM stockitemstockgroups
                          ) 
        AND ImagePath IS NOT NULL
        ORDER BY StockGroupID ASC";
      $Statement = mysqli_prepare($Connection, $Query);
      mysqli_stmt_execute($Statement);
      $Result = mysqli_stmt_get_result($Statement);
      $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    ?>
    <div id="Wrap">
      <?php 
        if (isset($StockGroups)) {
          $i = 0;
          foreach ($StockGroups as $StockGroup) {
            if ($i < 6) {
              ?>
              <a href="<?php print "browse.php?category_id=";
                print $StockGroup["StockGroupID"]; ?>">
                <div id="StockGroup3"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockGroup["ImagePath"]; ?>')"
                     class="StockGroups">
                  <h1 style="font-weight: bold; margin-top: 35%; height: 80px; -webkit-text-stroke: 2px black; font-size: 150%; display: flex; flex-direction: column; justify-content: center; text-align: center;">
                    <?php print($StockGroup["StockGroupName"]); ?>
                  </h1>
                </div>
              </a>
              <?php
              }
            $i++;
            }
        } 
      ?>
    </div>
  </div> 
</body>

<footer>
  <?php
    include __DIR__ . "/Footer.php";
  ?>
</footer>
  
</html>
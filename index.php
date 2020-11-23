<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel='stylesheet' href='style.css'>
    

</head>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>
<body >
    <div id="index">
        <h1></h1> <br>

        
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" style="height: 350px; width: 950px; margin-left: auto; margin-right: auto;">
    <div class="carousel-item active " style="width: auto; height: auto; background-color: rgba(128,128,128,0.5);">
      <img class="d-block" src="Public\ProductIMGHighRes\580b57fbd9996e24bc43bf55.png" alt="First slide" style="width: 30%; height: 300px;">
      <div>
      <h1>Titel</h1>
      </div>
    </div>
    <div class="carousel-item " style="width: 100%; height: auto; background-color: rgba(128,128,128,0.5);">
      <img class="d-block" src="Public\ProductIMGHighRes\usb.png" alt="First slide" style="width: 30%; height: 270px; margin-bottom: 15px; margin-top: 15px; margin-left: 20px; margin-right: 10px; ">
      <div >
      <h1>Titel</h1>
      </div>
    </div>
    <div class="carousel-item " style="width: auto; height: auto; background-color: rgba(128,128,128,0.5);">
      <img class="d-block" src="Public\ProductIMGHighRes\Hoodie.png" alt="First slide" style="width: 30%; height: 300px;">
      <div>
        <h1>Titel</h1>
      </div>
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

 


    <div>
</body>
</html>
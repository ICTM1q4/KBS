<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel='stylesheet' href='style.css'>
    
    <script>
        var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
    </script>
</head>
<header>
    <div id="totaal">
        <div id="titel">
            <picture id="picture"><img src="wauw%20(1).png"></picture>
            <h3> NerdyGadgets </h3>
        </div>
        <div id="categorie">
            <a href="index.php" class="button">Home</a>
            <a href="browse.php?category_id=1" class="button">Novelty Items</a>
            <a href="browse.php?category_id=2" class="button">Clothing</a>
            <a href="browse.php?category_id=4" class="button">T-Shirts</a>
            <a href="browse.php?category_id=6" class="button">Computing Novelties</a>
            <a href="browse.php?category_id=7" class="button">USB Novelties</a>
            <a href="browse.php?category_id=9" class="button">Toys</a>
            <a href="categories.php" class="button">Alle categorieen</a>
            

        </div>
        <input id="search" type="text" placeholder="search" style="right: ">
            <?php
            

            $login = false;
            if ($login == false){
                print("<a id='login' href='Login.php' class='button' style='color: white;'>login</a>");
            }
            else {
                print("<a id='login' href='Account.php' class='button' style='color: white;'>Account</a>");
            }
            ?>
        

    </div>

</header>
<body >
    <div id="index">
        <h1 > Goede Middag</h1>


            <!-- Slideshow container -->
<div class="slideshow-container">

<!-- Full-width images with number and caption text -->
<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="img_lights_wide.jpg" style="width:100%;  position: absolute;">
  <div class="text">Slide 1/3</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="img_nature_wide.jpg" style="width:100%; position: absolute;">
  <div class="text">Slide 2/3</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="img_snow_wide.jpg" style="width:100%;  position: absolute;">
  <div class="text">Slide 3/3</div>
</div>

<!-- Next and previous buttons -->
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
<span class="dot" onclick="currentSlide(1)"></span>
<span class="dot" onclick="currentSlide(2)"></span>
<span class="dot" onclick="currentSlide(3)"></span>
</div>


    <div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel='stylesheet' href='style.css'>
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
        
        <div class="background">
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

    </div>

</header>
<body>







</body>
</html>
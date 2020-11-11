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
            <a href="index.html" class="button">Home</a>
            <a href="" class="button">Categorie</a>
            <a href="" class="button">Categorie</a>
            <a href="" class="button">Over Ons</a>

        </div>
        <div class="background">
            <?php
            print('<input id="search" type="text" placeholder="search" style="right: ">');

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
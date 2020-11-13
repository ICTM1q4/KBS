<?php
session_start();
include "connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    
    <link rel='stylesheet' href='style.css'>
    
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="fontawesome.js"></script>
    
    <script src="jquery-3.4.1.js"></script>
    
</head>
<header>
    <div id="totaal">
        <div id="titel">
            <picture id="picture"><img src="wauw%20(1).png"></picture>
            <h3> NerdyGadgets </h3>
        </div>
        <div id="categorie">
            <a href="index.php" class="button" id="categories">Home</a>
            <!-- <a href="browse.php?category_id=" class="button">Novelty Items</a>
            <a href="browse.php?category_id=" class="button">Clothing</a>
            <a href="browse.php?category_id=" class="button">T-Shirts</a>
            <a href="browse.php?category_id=" class="button">Computing Novelties</a>
            <a href="browse.php?category_id=" class="button">USB Novelties</a>
            <a href="browse.php?category_id=" class="button">Toys</a>-->
            
            

            <?php
                $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
                $Statement = mysqli_prepare($Connection, $Query);
                mysqli_stmt_execute($Statement);
                $HeaderStockGroups = mysqli_stmt_get_result($Statement);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    
                        <a id="categories" href="browse.php?category_id=<?php 
                        print $HeaderStockGroup['StockGroupID'];
                        ?>"
                           class="button"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    
                    <?php
                }
                
                




                ?>
                <a href="categories.php" class="button" id="categories">Alle categorieen</a>
                <a href="contact.php" class="button" id="categories">Over Ons</a>
        </div>
        
        <div class="background">
            <form>
        <input type="text" name="search_string" id="search" id="search_string"
                   value="<?php print (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>"
                   class="form-submit">
            </form>
            <?php
            

            $login = false;
            if ($login == false){
                print("<a id='login' href='Login.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%;'>login</a>");
            }
            else {
                print("<a id='login' href='Account.php' id='categories' class='button' style='color: white;'>Account</a>");
            }
            ?>
        </div>

    </div>

</header>



<body>

</body>
</html>
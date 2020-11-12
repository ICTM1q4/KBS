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
    
    
    <script src="jquery-3.4.1.js"></script>
    
</head>
<header>
    <div id="totaal">
        <div id="titel">
            <picture id="picture"><img src="wauw%20(1).png"></picture>
            <h3> NerdyGadgets </h3>
        </div>
        <div id="categorie">
            <a href="index.php" class="button">Home</a>
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
                    
                        <a href="browse.php?category_id=<?php 
                        print $HeaderStockGroup['StockGroupID'];
                        ?>"
                           class="button"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    
                    <?php
                }
                
                




                ?>
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
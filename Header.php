<?php
session_start();
include "connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NerdyGagdets</title>
    <link rel='stylesheet' href='CSS/bootstrap.min.css'>
    <link rel='stylesheet' href='CSS/style.css'>
    <script src="JS/jquery.min.js"></script>
    <script src="JS/bootstrap.min.js"></script>
    <script src="JS/fontawesome.js"></script>
    <script src="JS/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        function sendToPage() {
            
            
            window.location = "browse.php";
            
            
        }
    </script>
</head>
<header style="color: white; background-color: black; border: black; padding-top: black;">
    <div id="totaal" style="color: inherit;">
        <div id="titel" style="color: inherit;">
            <a href="index.php" style="color: inherit;">
                <picture id="picture"><img src="Pictures/wauw%20(1).png"></picture>
                <h3 style="color: inherit;"> NerdyGadgets </h3>
    </a>
        </div>

        <div id="categorie" style="   overflow: visible;">
            <a href="index.php" class="button" id="categories">Home</a>
            <div id="categorie" class="dropdown" style="position: relative; font-family: Calibri; float: left; ">
                <button class="dropbtn" onclick="window.location.href='categories.php'">Producten
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content" style="position: absolute;">

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

                        <a id="categories" href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>
                                                       " class="button"><?php print $HeaderStockGroup['StockGroupName']; ?></a>

                    <?php
                    }

                    ?>

                </div>

            </div>
            <a href="overons.php" class="button" id="categories" style="margin-left: -400px;">Over Ons</a>
            <a href="contact.php" class="button" id="categories" style="margin-left: -280px;">Contact</a>         
        </div>

        <div class="background">
            <form action="browse.php">
            <a>
                <input type="text" name="search_string" id="search" id="search_string" placeholder="search" value="<?php print (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>" class="form-submit" onSubmit="sendToPage();">
            </a>
            </form>
            
            
            

            <?php
             
             
            
            $login = false;
            if(isset($_SESSION["Naam"])){
                if ($_SESSION["Naam"] != "" ){
                    print("<a id='login' href='Account.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float:right; padding-right: 50px;'>Account</a>");
                }
                else {
                    
                    print("<a id='login' href='login.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float:right; padding-right: 50px;'>Login</a>");
                }
                
            }
            else {
                print("<a id='login' href='login.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float:right; padding-right: 50px;'>Login</a>");
            }
            
            ?>
            <a id='winkelmand' href='winkelmand.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float: right; padding-right: 50px; margin-top: 0px; '>Winkelmand</a>
        </div>

    </div>

</header>



<body>

</body>

</html>
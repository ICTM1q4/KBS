<?php
session_start();
include "connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel='stylesheet' href='bootstrap.min.css'>
    <link rel='stylesheet' href='style.css'>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="fontawesome.js"></script>
    <script src="jquery-3.4.1.js"></script>
    <script type="text/javascript">
        function sendToPage(){
                var input = document.getElementById("search").value;
                var inputkey = document.getElementById("myInput");
                 //alert(input);
                 
                if (input != "" && event.keyCode != 13){
                    
                        window.location.href = "browse.php";
                    
                    
                }}

                    
    </script>
</head>
<header>
    <div id="totaal">
        <div id="titel">
            <a href="index.php">
                <picture id="picture"><img src="wauw%20(1).png"></picture>
                <h3> NerdyGadgets </h3>
    </a>
        </div>

        <div id="categorie" style="   overflow: visible;">
            <a href="index.php" class="button" id="categories">Home</a>
            <div id="categorie" class="dropdown" style="position: relative; font-family: Calibri; float: left; ">
                <button class="dropbtn" onclick="window.location.href='categories.php'">Alle categorieen
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
            <a href="contact.php" class="button" id="categories" style="margin-left: -400px;">Over Ons</a>

        </div>

        <div class="background">
            <form href="browse.php">
                <input type="text"  name="search_string" id="search" id="search_string" placeholder="search" value="<?php print (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>" class="form-submit" onclick="sendToPage(event);">
            </form>
            
            
            

            <?php
            $login = false;
            if ($login == false){
                print("<a id='login' href='login.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float:right; padding-right: 50px;'>Login</a>");
            }
            else {
                print("<a id='login' href='Account.php' id='categories' class='button' style='color: white;'>Account</a>");
            }
            ?>
            <a id='winkelmand' href='winkelmand.php' id='categories' class='button' style='color: white; font-family: Calibri; font-size: 150%; float: right; padding-right: 50px; '>Winkelmand</a>
        </div>

    </div>

</header>



<body>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Login
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    

</head>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>

<body style="height: 100%;">

<div style="color: white; margin-left: auto; margin-right: auto; width: 40%; margin-top: 40px; background-color: rgba(0,0,0,0.3); padding-top: 10%; padding-bottom: 10%;"> 
<p style="text-align: center;">Je bent ingelogd als: <?php print($_SESSION["Naam"]);?></p>
<a href="logout.php" >
<h1 style="color: white; text-align: center;">logout</h1>
</a>
</div>



</body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    <link rel='stylesheet' href='CSS/contact.css'>
</head>

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<body style="height: 80%;">
    <div style="height: 100%;">
        <form action="email.php" style="color: white; font-family: Calibri; margin: auto; width: 700px; font-size: 120%; margin-top: 3%;background-color: rgba(128,128,128,0.5); margin-top: 20px; border: 10px solid rgba(128,128,128,0.1); border-radius: 5px; padding-top: 10px; padding-left: 10px; padding-bottom: 10px;">
            <h1 style="color: white; font-family: Calibri;">Contactformulier:</h1>
            <div style="margin-left: 17px;">
                <label for="Titel">Titel:</label> <br>
                <input required type="text" id="Titel" name="Titel" style="width: 600px; border-top: 1px gray solid;"> <br>
                <label for="email">E-mail:</label> <br>
                <input required type="text" id="email" name="email" style="width: 600px; border-top: 1px gray solid;"> <br>
                <label for="beschrijving">Vraag/Klacht:</label> <br>
                <textarea required type="text" id="beschrijving" name="beschrijving" style="width: 600px; height: 300px; text-align: upper-left; border-top: 1px gray solid;"></textarea> <br>
                <input type="submit" id="submit" value="Versturen" style="margin-left: 30px; margin-top: 10px;">
            </div>    
        </form>
        <div class="contactinfo" style="background-color: rgba(128,128,128,0.5); width: 20%; margin-top: 20px; border: 10px solid rgba(128,128,128,0.1); border-radius: 5px; padding-top: 10px; padding-left: 10px; padding-bottom: 10px; margin-left: 75%; margin-top: -32%;">
            <h1>Contact</h1>
            <p>Telefoonnummer: 06123456</p>
            <br>
            <p></p>
            <h2>Sociale media</h2>
            <p> Twitter: </p> 
            <a href='twitter.com'>Nerdygadgets</a>
            <br>
            <p> Facebook: </p> 
            <a href='facebook.com'>Nerdygadgets</a>
        </div>
    </div>
</body>

<footer style="margin-top: -40px;">
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>

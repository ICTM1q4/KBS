<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>
        Login
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel='stylesheet' href='CSS/style.css'>
</head>

    <style>

        body {
            color: #fff;
            background: #63738a;
            
        }

        .form-control {
            height: 40px;
            box-shadow: none;
            color: #969fa4;
        }

        .form-control:focus {
            border-color: #5cb85c;
        }

        .form-control, .btn {
            border-radius: 3px;
        }

        .signup-form {
            width: 400px;
            margin: 0 auto;
            padding: 30px 0;
        }

        .signup-form h2 {
            color: #636363;
            margin: 0 0 15px;
            position: relative;
            text-align: center;
        }

        .signup-form h2:before, .signup-form h2:after {
            content: "";
            height: 2px;
            width: 25%;
            background: purple;
            position: absolute;
            top: 50%;
            z-index: 2;
        }

        .signup-form h2:before {
            left: 0;
        }

        .signup-form h2:after {
            right: 0;
        }

        .signup-form .hint-text {
            color: #999;
            margin-bottom: 30px;
            text-align: center;
        }

        .signup-form form {
            color: #999;
            border-radius: 3px;
            margin-bottom: 15px;
            background: antiquewhite;
            box-shadow: 5px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .signup-form .form-group {
            margin-bottom: 20px;
        }

        .signup-form input[type="checkbox"] {
            margin-top: 3px;
        }

        .signup-form .btn {
            font-size: 16px;
            font-weight: bold;
            min-width: 140px;
            outline: none !important;
        }

        .signup-form .row div:first-child {
            padding-right: 20px;
        }

        .signup-form .row div:last-child {
            padding-left: 10px;
        }

        .signup-form a {
            color: pink;
            text-decoration: underline;
        }

        .signup-form a:hover {
            text-decoration: none;
        }

        .signup-form form a {
            color: #5cb85c;
            text-decoration: none;
        }

        .signup-form form a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<header style="color: white; font-family: Calibri;">
    <?php
        include __DIR__ . "/Header.php";
        
    ?>
</header>

<?php 
    if(isset($_SESSION["Naam"])) {
        echo "<script>window.location = 'index.php'</script>";
    }
?>

<body style="height: 100%; background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
    <div class="signup-form" style="margin-left: 600px; margin-top: 100px;">
        <form action="DatabaseLogin.php" method="post" style="height: 400px; width: 700px; margin: auto;">
            <h2 style="font-size: ">Inloggen</h2>
            <?php if(isset($_GET["Login"])){
                if ($_GET["Login"] == "fout"){
                    ?> <p style="color: rgb(200,0,0)"> Wachtwoord of Username klopt niet </p><?php 
                }
            }
            
            
            
            ?>
            <?php 
            $ww1 = '';
            $naam1 = '';
            
            if (isset($_SESSION['ww1'])){$ww1 = $_SESSION['ww1'];}
            if (isset($_SESSION['naam1'])){$naam1 = $_SESSION['naam1'];}
            ?>
            
            <p class="hint-text"></p>
            <div class="form-group">
                <input type="Text" class="form-control" name="Username" value="<?php print($naam1);?>" placeholder="Gebruikersnaam" required="required" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="Password" value="<?php print($ww1);?>" placeholder="Wachtwoord" required="required" >
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Inloggen</button>
            </div>
    </div>

    <div class="text-center" style="color: white">
        Heb je nog geen account?  
        <a href="Signup.php">
            Meld je hier aan
        </a>
    </div>



</body>

<footer style="padding-top: 160px;">
    <?php
    include __DIR__ . "/Footer.php";
    ?>
</footer>

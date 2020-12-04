<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        NerdyGadgets
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel='stylesheet' href='style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            color: #fff;
            background: #63738a;
            font-family: 'Roboto', sans-serif;
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

<header>
    <?php
        include __DIR__ . "/Header.php";
    ?>
</header>

<body style="background-image: linear-gradient(45deg, #693675, #1e008a); background-attachment: fixed;">
<div class="signup-form">
    <form action="DatabaseSignup.php" method="post" style="width: 500px; margin-left: -50px;">
        <h2> Registreren</h2>
        <p class="hint-text">Maak een nieuw account aan</p>
        <div class="form-group">
            <input type="Text" class="form-control" name="Username" placeholder="Gebruikersnaam" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="Password" placeholder="Wachtwoord" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Herhaal wachtwoord" required="required">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6" style="margin-left:15px;"><input type="text" class="form-control" name="firstname" placeholder="Voornaam" required="required">
                </div>
                <div class="col-xs-6"><input type="text" class="form-control" name="lastname" placeholder="Achternaam" required="required">
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="Text" class="form-control" name="address" placeholder="Adres" required="required">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6" style="margin-left:15px;">
                    <input type="text" class="form-control" name="zipcode" placeholder="Postcode" required="required">
                </div>
                <div class="col-xs-6">
                    <input type="number" class="form-control" name="phonenumber" placeholder="Telefoonnummer">
                </div>
            </div>
            <?php if(isset($_GET["registreer"])){
                if ($_GET["registreer"] == "fout"){
                    ?> <p style="color: rgb(200,0,0); margin-top: 5px;"> Wachtwoord of Gebruikersnaam klopt niet </p><?php
                }
            }
            
            
            
            ?>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Account aanmaken</button>
        </div>
    </div>
    <div class="text-center" style="color: white">Heb je al een account? 
        <a href="login.php">
            Log in
        </a>
    </div>
</body>

<footer>
    <?php
        include __DIR__ . "/Footer.php";
    ?>
</footer>

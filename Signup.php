<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
    NerdyGadgets
    </title>
    <link rel='stylesheet' href='CSS/style.css'>
    

</head>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>

<body>
    <div style="
    background: rgba(0,0,0,0.5);
    border: 10px rgba(0,0,0,0.5) solid;
    border-radius: 10px;
    height: 1000px;
    margin-top: 10px;
    
    width: 90%;
    margin-left: auto;
    margin-right: auto;">
    <table style="margin-left: 50px; width: 100%; height: 70%;">
        <tr style="width: 80%;">
            <td style="width: 40%; margin: auto;" >
                <h1 style="font-family: Calibri; color: white;">Registreer:</h1>
                <div id="SignIn" style="font-family: Calibri; min-width: 450px;">
                <form action="DatabaseSignup.php" style="margin-left: 20px; padding-top: 20px;" method="post">
                <table>
                    <tr>
                        <td>
                        <label for="Username">*Username:</label><br>
                        <input required type="text" id="Username" name="Username"><br>
                        <label for="Password">*Password:</label><br>
                        <input required type="text" id="Password" name="Password"><br>
                        <label for="Password">*First Name:</label><br>
                        <input required type="text" id="firstname" name="firstname"><br>
                        <label for="Password">*Last Name:</label><br>
                        <input required type="text" id="lastname" name="lastname"><br>
                        </td>
                        <td>
                        <label for="Password">*Address:</label><br>
                        <input required type="text" id="address" name="address"><br>
                        <label for="Password">*Zipcode:</label><br>
                        <input required type="text" id="zipcode" name="zipcode"><br>
                        <label for="Password">Phonenumber:</label><br>
                        <input type="text" id="phonenumber" name="phonenumber"><br>
                        <label for="Password">*E-mail:</label><br>
                        <input required type="text" id="email" name="email"><br>
                        </td>
                        </tr>
                        </table>
                        <?php if(isset($_GET["Registreer"])) {
                            if ($_GET["Registreer"] == "fout"){
                                print("<p style='color: rgb(200,0,0);'>Username is al gebruikt</p>");
                        }
                        }?>
                        <br>
                        <input type="submit" value="Sign up">
                    </form>
                </div>
            </td>
        </tr>
    </table>
        
    </div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
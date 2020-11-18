<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Login
    </title>
    <link rel='stylesheet' href='style.css'>
    

</head>
<header>
<?php
include __DIR__ . "/Header.php";
?>
</header>

<body style="height: 100%;">
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
                <h1 style="font-family: Calibri; color: white;">Log in:</h1>
                <div id="SignUp" style="font-family: Calibri;">
                    <form action="DatabaseLogin.php" style="margin-left: 20px; padding-top: 20px;" method="post">
                        <label for="Username">Username:</label><br>
                        <input required type="text" id="Username" name="Username"><br>
                        <label for="Password">Password:</label><br>
                        <input required type="text" id="Password" name="Password"><br><br>
                        <input type="submit" value="Sign in">
                    </form>
                    <a href="Signup.php"> 
                        <br>
                    <h1 style="margin-left: 20px; font-size: 90%;">Sign up</h1>
                    </a>
                </div>
                
            </td>
        </tr>
    </table>
        
    </div>
</body>
<?php
include __DIR__ . "/Footer.php";
?>
<?php
    include "connect.php";

//PREPARE ALL VARIABLES
    $gebruikersNaam = "";
    $gebruikersWachtwoord = "";

<<<<<<< HEAD
if (isset($_POST["Username"]) && isset($_POST["Password"])){
    $gebruikersNaam = $_POST["Username"];
    $gebruikersWachtwoord = $_POST["Password"];
}
=======
//CHECK IF DATA IS SET
    if (isset($_POST["Username"]) && isset($_POST["Password"])){
        $gebruikersNaam = $_POST["Username"];
        $gebruikersWachtwoord = $_POST["Password"];
    }
>>>>>>> 5cea190212d45d7eac31d0ff7f6bf7719dc9b18e

//CONVERT PASSWORD TO HASH
    $gebruikersWachtwoord = hash("SHA256", $gebruikersWachtwoord);;

<<<<<<< HEAD
$Query = "
                SELECT username, password, firstname, lastname
                FROM webcustomers
                WHERE username = ?
                AND password = ?;";

=======
//PULL DATA FROM DATABASE TO COMPARE
    $Query = "
            SELECT username, password, firstname, lastname
            FROM webcustomer
            WHERE username = ?
            AND password = ?;";
>>>>>>> 5cea190212d45d7eac31d0ff7f6bf7719dc9b18e

    // $Statement = mysqli_prepare($Connection, $Query);
    // mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    // mysqli_stmt_execute($Statement);
    // $ReturnableResult = mysqli_stmt_get_result($Statement);
    // $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

//FOR EVERY ROW IN THE RESULT, CHECK IF INPUT IS SAME AS DATA IN DATABASE AND SAVE IN SESSION
    foreach ($ReturnableResult as $ReturnableResult){
        if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
            print("Welkom ".$ReturnableResult['firstname']. $ReturnableResult['lastname'].", je bent zojuist ingelogd!");
            session_start();
            $_SESSION["Naam"] = $gebruikersNaam;
            
            $Query = "
                    SELECT WO.OrderID, WC.username as username, WC.Address address, WC.zipcode zip
                    FROM weborder WO
                    JOIN webcustomer WC ON WO.CustomerID = WC.CustomerID
                    WHERE username = ?
                    AND password = ?;";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "ii", $_SESSION["Naam"], $gebruikersWachtwoord);
            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
            foreach ($ReturnableResult as $ReturnableResult){
                if ($gebruikersNaam == $ReturnableResult["username"]){
                    $_SESSION["OrderID"] = $ReturnableResult["OrderID"];
                    $_SESSION["Address"] = $ReturnableResult["address"];
                    $_SESSION["Zip"] = $ReturnableResult["zip"];
                    print($_SESSION["Naam"] . $ReturnableResult["OrderID"]);
                }
            }
//GO BACK
            $_SESSION["loggedin"] = "ja";
            echo "<script>window.location = 'login.php?Login=goed'</script>";
            break;
        }

//IF INPUT IS INCORRECT, GO BACK AND GIVE ERROR
        else if ($ReturnableResult["username"] != $gebruikersNaam && $ReturnableResult != $gebruikersWachtwoord ){
            echo "<script>window.location = 'login.php?Login=fout'</script>"; 
        }
    }

<<<<<<< HEAD
if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
    print("Welkom ".$ReturnableResult['firstname']. $ReturnableResult['lastname'].", je bent zojuist ingelogd!");
    $_SESSION["loggedin"] == true;
}
else {
    print("<h1>Gegevens incorrect, probeer opnieuw</h1>");
}
=======
>>>>>>> 5cea190212d45d7eac31d0ff7f6bf7719dc9b18e



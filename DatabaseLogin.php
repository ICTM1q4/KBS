<?php
    include "connect.php";
    session_start();
//PREPARE ALL VARIABLES
    $gebruikersNaam = "";
    $gebruikersWachtwoord = "";

//CHECK IF DATA IS SET
    if (isset($_POST["Username"]) && isset($_POST["Password"])){
        $gebruikersNaam = $_POST["Username"];
        $gebruikersWachtwoord = $_POST["Password"];
        $_SESSION['naam1'] = $_POST["Username"];
        $_SESSION['ww1']  = $_POST["Password"];
        
    }
    
    
    

//CONVERT PASSWORD TO HASH
    $gebruikersWachtwoord = hash("SHA256", $gebruikersWachtwoord);

//PULL DATA FROM DATABASE TO COMPARE
    $Query = "
            SELECT username, password, firstname, lastname, CustomerID
            FROM webcustomer
            WHERE username = ?
            AND password = ?;";

    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $gebruikersNaam, $gebruikersWachtwoord);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    
//FOR EVERY ROW IN THE RESULT, CHECK IF INPUT IS SAME AS DATA IN DATABASE AND SAVE IN SESSION
    foreach ($ReturnableResult as $ReturnableResult){
        if ($ReturnableResult["username"] == $gebruikersNaam && $ReturnableResult["password"] == $gebruikersWachtwoord ){
            print("Welkom ".$ReturnableResult['firstname']. $ReturnableResult['lastname'].", je bent zojuist ingelogd!");
            
            $_SESSION["Naam"] = $gebruikersNaam;
            $_SESSION["Customer"] = $ReturnableResult['CustomerID'];
            $Query = "
                    SELECT WO.OrderID OrderID, WC.username as username, WC.Address address, WC.zipcode zip, WC.CustomerID CustomerID 
                    FROM weborder WO
                    JOIN webcustomer WC ON WO.CustomerID = WC.CustomerID
                    WHERE username = ?
                    AND password = ?
                    AND Payment = 0;";

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
                    $_SESSION["Customer"] = $ReturnableResult["CustomerID"];
                    print($_SESSION["Naam"] . $ReturnableResult["OrderID"]);
                }
            }
//GO BACK
            $_SESSION["loggedin"] = "ja";
            print('wut1');
            echo "<script>window.location = 'login.php?Login=goed'</script>";
            break;
        }

//IF INPUT IS INCORRECT, GO BACK AND GIVE ERROR
        else {
            
            echo "<script>window.location = 'login.php?Login=fout&naam1=" . $gebruikersNaam . "'</script>"; 
        }
    }
    echo "<script>window.location = 'login.php?Login=fout&naam1=" . $gebruikersNaam . "'</script>"; 



